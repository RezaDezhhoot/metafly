package system

import (
	src "api"
	"api/config"
	"github.com/joho/godotenv"
	"log"
	"os"
	"sync"
)

type System struct {
	EnvDir string
}

var (
	s    *System
	once sync.Once
)

func New(envDir string) *System {
	once.Do(func() {
		s = &System{
			EnvDir: envDir,
		}
		_, err := os.Open(envDir)
		if err == nil {
			err = godotenv.Load(envDir)
			if err != nil {
				log.Fatalln("Error loading .env file")
			}
			log.Println("Env loaded")
			s.Init()
		} else {
			log.Fatalf("Error loading .env file:%v \n", err)
		}
	})
	return s
}

func (s *System) Init() {
	var err error

	config.InitAppConfig()
	err = config.InitPostgres()

	if err != nil {
		log.Fatalf("Error connection DB: %v \n", err)
	}
	config.InitValidation()
}

func (s *System) Run() {
	defer config.ClosePostgres()
	src.InitServer()
}
