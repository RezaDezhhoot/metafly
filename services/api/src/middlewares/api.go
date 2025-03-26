package middlewares

import (
	"github.com/gin-gonic/gin"
)

func API() gin.HandlerFunc {
	return func(c *gin.Context) {
		if c.GetHeader("Accept") != "application/json" {
			c.AbortWithStatusJSON(400, gin.H{
				"message": "Error",
			})
			return
		}
		c.Next()
	}
}
