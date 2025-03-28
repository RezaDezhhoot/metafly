package routes

import (
	"api/packages/v1/category"
	"api/packages/v1/faq"
	"api/packages/v1/post"
	"api/packages/v1/settings"
	"github.com/gin-gonic/gin"
)

func Api(r *gin.RouterGroup) {
	v1 := r.Group("v1")
	{
		ctrRouter := v1.Group("categories")
		{
			ctrRouter.GET("", category.Index)
		}
		stgRouter := v1.Group("settings")
		{
			stgRouter.GET("", settings.Find)
		}
		pstRouter := v1.Group("posts")
		{
			pstRouter.GET("", post.Index)
			pstRouter.GET("points", post.Points)
			pstRouter.GET(":id/comments", post.Comments)
			pstRouter.POST(":id/comments", post.SendComment)
			pstRouter.POST(":id/comments/:comment/like", post.LikeComment)
			pstRouter.GET(":id", post.Show)
		}
		faqRouter := v1.Group("faq")
		{
			faqRouter.GET("", faq.Index)
		}
	}

}
