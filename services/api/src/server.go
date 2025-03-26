package src

import (
	"api/middlewares"
	"api/routes"
	"github.com/gin-gonic/gin"
	"log"
	"net/http"
	"time"
)

func InitServer() {
	r := gin.New()
	r.Use(gin.Logger(), gin.Recovery(), middlewares.Cors())
	r.Static("/storage", "./public/storage")
	r.Use(middlewares.API())
	routes.Api(&r.RouterGroup)
	hs := &http.Server{
		Handler:     r,
		Addr:        ":3000",
		ReadTimeout: time.Second * 30,
	}
	err := hs.ListenAndServe()
	if err != nil {
		log.Fatalf("Error serving: %v \n", err)
	}
}
