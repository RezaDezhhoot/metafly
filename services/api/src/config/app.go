package config

import "os"

type AppConfig struct {
	AppEnv string
}

var appConfig *AppConfig

func InitAppConfig() {
	appConfig = &AppConfig{
		AppEnv: os.Getenv("API_ENV"),
	}
}

func GetAppConfig() *AppConfig {
	return appConfig
}
