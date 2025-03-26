package category

import (
	"api/config"
	"api/helpers"
	"api/packages/v1/base"
	"errors"
	"github.com/gin-gonic/gin"
	"gorm.io/gorm"
	"strconv"
)

func Index(c *gin.Context) {
	categoryType := c.Query("type")
	if categoryType == "" {
		categoryType = TOUR
	}
	parentID := c.Query("parent")
	pg := base.NewPagination(c)

	var results []Category
	DB := config.GetPostgres()
	q := DB.Model(&Category{}).Order("id desc").Scopes(WithParent(), WithChildren()).Where("type = ?", categoryType).Offset(pg.Offset()).Limit(pg.PerPage())
	if v, err := strconv.Atoi(parentID); err != nil || v <= 0 {
		q.Where("parent_id IS NULL")
	} else {
		q.Where("parent_id = ?", parentID)
	}
	res := q.Find(&results)
	if res.Error != nil && !errors.As(res.Error, &gorm.ErrRecordNotFound) {
		c.AbortWithStatusJSON(500, base.GenerateBaseResponseWithError(nil, false, 500, res.Error))
		return
	}
	var total int64
	res.Count(&total)
	helpers.Traverse(&results, "Children", func(i int, item *Category) {
		if item.Image != nil {
			image := helpers.Asset(*item.Image)
			item.Image = &image
		}
		if item.Parent != nil && item.Parent.Image != nil {
			image := helpers.Asset(*item.Image)
			item.Parent.Image = &image
		}
	})
	c.JSON(200, base.GenerateBaseResponse(results, true, 200, "", &base.MetaData{
		CurrentPage: pg.Page(),
		PerPage:     pg.PerPage(),
		LastPage:    pg.LastPage(float64(total)),
		Total:       total,
	}))
}
