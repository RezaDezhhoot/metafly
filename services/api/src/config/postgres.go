package config

import (
	"fmt"
	"gorm.io/driver/postgres"
	"gorm.io/gorm"
	"gorm.io/gorm/logger"
	"log"
	"os"
	"time"
)

var pg *gorm.DB

func InitPostgres() error {
	dsn := fmt.Sprintf("host=%s user=%s password=%s dbname=%s port=%d sslmode=disable TimeZone=Asia/Tehran",
		os.Getenv("DB_HOST"), os.Getenv("DB_USERNAME"), os.Getenv("DB_PASSWORD"), os.Getenv("DB_DATABASE"), 5423,
	)

	var lgr logger.Interface = nil

	if GetAppConfig().AppEnv == "local" {
		lgr = logger.New(
			log.New(os.Stdout, "\r\n", log.LstdFlags),
			logger.Config{
				SlowThreshold:             time.Second,
				LogLevel:                  logger.Info,
				IgnoreRecordNotFoundError: false,
				ParameterizedQueries:      true,
				Colorful:                  true,
			},
		)
	}

	db, err := gorm.Open(postgres.Open(dsn), &gorm.Config{
		Logger:                           lgr,
		IgnoreRelationshipsWhenMigrating: true,
	})
	if err != nil {
		return err
	}
	pg = db
	return nil
}

func GetPostgres() *gorm.DB {
	return pg
}

func ClosePostgres() {
	db, _ := pg.DB()
	err := db.Close()
	if err != nil {
		log.Fatalf("Failed to close mysql connection: %v", err)
	}
}
