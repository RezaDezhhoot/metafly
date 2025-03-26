package main

import "api/system"

func main() {
	s := system.New(".env")
	s.Run()
}
