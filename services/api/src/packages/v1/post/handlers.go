package post

import (
	"api/config"
	"api/helpers"
	"api/packages/v1/base"
	"api/packages/v1/category"
	"encoding/json"
	"errors"
	"fmt"
	"github.com/gin-gonic/gin"
	"gorm.io/gorm"
)

func Index(c *gin.Context) {
	pg := base.NewPagination(c)
	DB := config.GetPostgres()

	var (
		results    []Post
		mostViewed []Post
	)
	q := DB.Model(&Post{}).Scopes(Published(), Summary(), WithCategories(), WithAuthor()).Offset(pg.Offset()).Limit(pg.PerPage())

	sort := c.Query("sort")
	if sort != "" && helpers.InArray([]string{"created_at", "views"}, sort) {
		q.Order(fmt.Sprintf("%s desc", sort))
	} else {
		q.Order("id desc")
	}

	if search := c.Query("q"); len([]rune(search)) > 0 {
		q.Where(DB.Where("title ILIKE ?", "%"+search).Or("slug ILIKE ?", "%"+search))
	}

	if categories := c.QueryArray("categories"); len(categories) > 0 {
		q.Joins("JOIN categoryables ON categoryables.categoryable_id = posts.id").Where("categoryables.category_id IN ? AND categoryables.categoryable_type = ?", categories, "post")
	}

	res := q.Group("posts.id").Find(&results)
	var total int64
	q.Count(&total)
	if res.Error != nil && !errors.As(res.Error, &gorm.ErrRecordNotFound) {
		c.AbortWithStatusJSON(500, base.GenerateBaseResponseWithError(nil, false, 500, res.Error))
		return
	}
	_ = DB.Model(&Post{}).Scopes(Summary(), WithCategories(), WithAuthor()).Order("views desc").Limit(3).Find(&mostViewed)
	totalResults := append(results, mostViewed...)
	helpers.Map(&totalResults, func(i int, item *Post) {
		item.Image = helpers.Asset(item.Image)
		if item.Author.Image != nil {
			avatar := helpers.Asset(*item.Author.Image)
			item.Author.Image = &avatar
		}
		if len(item.Categories) > 0 {
			helpers.Map(&item.Categories, func(i int, item *category.Categoryable) {
				if item.Category.Image != nil {
					image := helpers.Asset(*item.Category.Image)
					item.Category.Image = &image
				}
				if item.Category.Parent != nil && item.Category.Parent.Image != nil {
					image := helpers.Asset(*item.Category.Image)
					item.Category.Parent.Image = &image
				}
			})
		}
	})
	c.JSON(200, base.GenerateBaseResponse(results, true, 200, "", &base.MetaData{
		CurrentPage: pg.Page(),
		PerPage:     pg.PerPage(),
		LastPage:    pg.LastPage(float64(total)),
		Total:       total,
		ExtraData: base.ExtraData{
			"most_viewed": mostViewed,
		},
	}))
}

func Show(c *gin.Context) {
	slug, ok := c.Params.Get("slug")
	if !ok {
		c.AbortWithStatusJSON(404, base.GenerateBaseResponse(nil, false, 404, "", nil))
		return
	}
	DB := config.GetPostgres()
	var (
		result       Post
		relatedPosts []Post
	)
	q := DB.Model(&Post{}).Where("slug = ?", slug).Scopes(WithCategories(), WithAuthor(), Published()).First(&result)
	if q.Error != nil {
		if errors.As(q.Error, &gorm.ErrRecordNotFound) {
			c.AbortWithStatusJSON(404, base.GenerateBaseResponse(nil, false, 404, "", nil))
			return
		} else {
			c.AbortWithStatusJSON(500, base.GenerateBaseResponseWithError(nil, false, 404, q.Error))
			return
		}
	}
	result.Image = helpers.Asset(result.Image)
	if result.Author.Image != nil {
		avatar := helpers.Asset(*result.Author.Image)
		result.Author.Image = &avatar
	}
	if result.Content != nil && json.Valid([]byte(*result.Content)) {
		_ = json.Unmarshal([]byte(*result.Content), &result.ContentWrapped)
	}
	if len(result.Categories) > 0 {
		helpers.Map(&result.Categories, func(i int, item *category.Categoryable) {
			if item.Category.Image != nil {
				image := helpers.Asset(*item.Category.Image)
				item.Category.Image = &image
			}
			if item.Category.Parent != nil && item.Category.Parent.Image != nil {
				image := helpers.Asset(*item.Category.Image)
				item.Category.Parent.Image = &image
			}
		})
	}
	c.JSON(200, base.GenerateBaseResponse(result, true, 200, "", &base.MetaData{
		ExtraData: base.ExtraData{
			"related_posts": relatedPosts,
		},
	}))
}
