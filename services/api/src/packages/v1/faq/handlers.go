package faq

import (
	"api/config"
	"api/packages/v1/base"
	"github.com/gin-gonic/gin"
)

func Index(c *gin.Context) {
	pg := base.NewPagination(c)
	DB := config.GetPostgres()

	var (
		results []FAQ
		total   int64
	)
	q := DB.Model(&FAQ{}).Order("id desc").Offset(pg.Offset()).Limit(pg.PerPage()).Find(&results)
	if q.Error != nil {
		base.GenerateBaseResponseWithError(nil, false, 500, q.Error)
		return
	}
	q.Count(&total)

	c.JSON(200, base.GenerateBaseResponse(results, true, 200, "", &base.MetaData{
		CurrentPage: pg.Page(),
		PerPage:     pg.PerPage(),
		LastPage:    pg.LastPage(float64(total)),
		Total:       total,
	}))
}
