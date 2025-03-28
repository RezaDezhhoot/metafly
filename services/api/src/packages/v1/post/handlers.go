package post

import (
	"api/config"
	"api/helpers"
	"api/packages/v1/base"
	"api/packages/v1/category"
	"api/packages/v1/comment"
	"api/packages/v1/point"
	"api/packages/v1/user"
	"encoding/json"
	"errors"
	"fmt"
	"github.com/gin-gonic/gin"
	"gorm.io/gorm"
	"strconv"
	"sync"
)

var (
	sendCommentMx sync.Mutex
	likeCommentMx sync.Mutex
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
	if points := c.QueryArray("points"); len(points) > 0 {
		q.Joins("JOIN object_points op ON op.object_id = posts.id").Where("op.point_id IN ? AND op.object_type = ?", points, "post")
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
	id, ok := c.Params.Get("id")
	if !ok {
		c.AbortWithStatusJSON(404, base.GenerateBaseResponse(nil, false, 404, "", nil))
		return
	}
	DB := config.GetPostgres()
	var (
		result       Post
		relatedPosts []Post
	)
	q := DB.Model(&Post{}).Where("id = ?", id).Scopes(WithCategories(), WithAuthor(), Published(), WithTopics()).First(&result)
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
	DB.Model(&Post{}).Where("id = ?", result.ID).UpdateColumn("views", gorm.Expr("views + ?", 1))
	result.Views++
	c.JSON(200, base.GenerateBaseResponse(result, true, 200, "", &base.MetaData{
		ExtraData: base.ExtraData{
			"related_posts": relatedPosts,
		},
	}))
}

func Comments(c *gin.Context) {
	pg := base.NewPagination(c)
	DB := config.GetPostgres()
	id, ok := c.Params.Get("id")
	if !ok {
		c.AbortWithStatusJSON(404, base.GenerateBaseResponse(nil, false, 404, "", nil))
		return
	}
	postID, err := strconv.Atoi(id)
	if err != nil || postID < 0 {
		c.AbortWithStatusJSON(404, base.GenerateBaseResponse(nil, false, 404, "", nil))
		return
	}
	var (
		results []comment.Comment
		total   int64
	)
	q := DB.Model(&comment.Comment{}).Order("id desc").Scopes(comment.Published(), comment.WithRepliesCount(), comment.WithUser())
	parent := c.Query("parent")
	if parentID, err := strconv.Atoi(parent); err == nil && parentID > 0 {
		q.Where("reply_on = ?", parentID)
	} else {
		q.Where("reply_on IS NULL")
	}
	res := q.Where("commentable_id = ? AND commentable_type = ?", postID, "post").
		Offset(pg.Offset()).
		Limit(pg.PerPage()).
		Find(&results)
	res.Count(&total)
	helpers.Map(&results, func(i int, item *comment.Comment) {
		println(item.User.ID)
		if item.User.Image != nil {
			avatar := helpers.Asset(*item.User.Image)
			item.User.Image = &avatar
		}
	})

	c.JSON(200, base.GenerateBaseResponse(results, true, 200, "", &base.MetaData{
		CurrentPage: pg.Page(),
		PerPage:     pg.PerPage(),
		LastPage:    pg.LastPage(float64(total)),
		Total:       total,
	}))
}

func SendComment(c *gin.Context) {
	id, ok := c.Params.Get("id")
	if !ok {
		c.AbortWithStatusJSON(404, base.GenerateBaseResponse(nil, false, 404, "", nil))
		return
	}
	postID, err := strconv.Atoi(id)
	if err != nil || postID < 0 {
		c.AbortWithStatusJSON(404, base.GenerateBaseResponse(nil, false, 404, "", nil))
		return
	}
	type SendCommentBody struct {
		Body    string `json:"body" form:"body" validate:"required,min=4,max=100000000"`
		Name    string `json:"name" form:"name" validate:"required,min=2,max=20"`
		Email   string `json:"email" form:"email" validate:"required,email,max=200"`
		Phone   string `json:"phone" form:"phone" validate:"required,number,len=11"`
		ReplyOn *uint  `json:"reply_on" form:"reply_on" validate:"omitempty,number,gte=1"`
	}
	var sendCommentBody SendCommentBody
	if err = c.ShouldBind(&sendCommentBody); err != nil {
		c.AbortWithStatusJSON(400, base.GenerateBaseResponseWithError(nil, false, 400, err))
		return
	}
	v := config.Validator()
	err = v.Struct(&sendCommentBody)
	if err != nil {
		c.AbortWithStatusJSON(422, base.ValidationError(nil, false, 422, err))
		return
	}
	DB := config.GetPostgres()
	if sendCommentBody.ReplyOn != nil && *sendCommentBody.ReplyOn > 0 {
		var check int64
		_ = DB.Model(&comment.Comment{}).Select("*,COUNT(id)").Where("id = ? AND commentable_type = ?", sendCommentBody.ReplyOn, "post").Count(&check)
		if check <= 0 {
			c.AbortWithStatusJSON(404, base.GenerateBaseResponse(nil, false, 404, "", nil))
			return
		}
	} else {
		sendCommentBody.ReplyOn = nil
	}

	var sender user.User
	DB.Where("phone = ? OR email = ?", sendCommentBody.Phone, sendCommentBody.Email).
		Select("*").
		Attrs(user.User{Name: sendCommentBody.Name, Email: sendCommentBody.Email, Phone: &sendCommentBody.Phone}).
		FirstOrCreate(&sender)
	newComment := comment.Comment{
		Body:            sendCommentBody.Body,
		CommentableID:   postID,
		CommentableType: "post",
		Status:          comment.DRAFT,
		IsAdmin:         false,
		UserID:          sender.ID,
		ReplyOn:         sendCommentBody.ReplyOn,
	}
	sendCommentMx.Lock()
	defer sendCommentMx.Unlock()
	newComment.User = sender
	res := DB.Model(&comment.Comment{}).Create(&newComment)
	if res.Error != nil {
		c.AbortWithStatusJSON(500, base.GenerateBaseResponseWithError(nil, false, 500, res.Error))
		return
	}
	c.JSON(201, base.GenerateBaseResponse(newComment, true, 201, "", nil))
}

func LikeComment(c *gin.Context) {
	id, ok := c.Params.Get("comment")
	if !ok {
		c.AbortWithStatusJSON(404, base.GenerateBaseResponse(nil, false, 404, "", nil))
		return
	}
	commentId, err := strconv.Atoi(id)
	if err != nil || commentId < 0 {
		c.AbortWithStatusJSON(404, base.GenerateBaseResponse(nil, false, 404, "", nil))
		return
	}
	DB := config.GetPostgres()
	var result comment.Comment
	res := DB.Model(&comment.Comment{}).Where("id = ? AND commentable_type = ?", commentId, "post").Scopes(comment.WithUser(), comment.WithParent(), comment.WithRepliesCount()).First(&result)
	if res.Error != nil {
		c.AbortWithStatusJSON(404, base.GenerateBaseResponse(nil, false, 404, "", nil))
		return
	}
	likeCommentMx.Lock()
	defer likeCommentMx.Unlock()
	DB.Model(&result).UpdateColumn("likes", gorm.Expr("likes + ?", 1))

	result.Likes++
	c.JSON(201, base.GenerateBaseResponse(result, true, 201, "", nil))
}

func Points(c *gin.Context) {
	pg := base.NewPagination(c)
	DB := config.GetPostgres()
	var (
		results []point.Point
		total   int64
	)
	q := DB.Model(&point.Point{}).Select("points.*,COUNT(op.id) AS objects_count").
		Joins("JOIN object_points op ON op.point_id = points.id").
		Where("op.object_type = ?", "post").
		Group("points.id").
		Offset(pg.Offset()).
		Limit(pg.PerPage()).
		Find(&results)

	if q.Error != nil {
		c.AbortWithStatusJSON(500, base.GenerateBaseResponseWithError(nil, false, 500, q.Error))
		return
	}
	q.Count(&total)
	helpers.Map(&results, func(i int, item *point.Point) {
		title := point.ToCountry(item.Country).Label()
		item.Title = &title
		item.Image = helpers.Asset(item.Image)
	})
	c.JSON(200, base.GenerateBaseResponse(results, true, 200, "", &base.MetaData{
		CurrentPage: pg.Page(),
		PerPage:     pg.PerPage(),
		LastPage:    pg.LastPage(float64(total)),
		Total:       total,
	}))
}
