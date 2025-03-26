package helpers

import (
	"fmt"
	"os"
	"reflect"
	"regexp"
	"strings"
)

func Asset(path string) string {
	if ok, err := regexp.MatchString(`^(https?|ftp):\/\/[^\s/$.?#].[^\s]*$`, path); ok && err == nil {
		return path
	}
	if ok, err := regexp.MatchString(`^(http?|ftp):\/\/[^\s/$.?#].[^\s]*$`, path); ok && err == nil {
		return path
	}
	if ok, err := regexp.MatchString(`^([A-Za-z0-9-]+\.)+[A-Za-z]{2,}(/[\w\-./]*)?$`, path); ok && err == nil {
		return path
	}

	return fmt.Sprintf("%s/%s", strings.Trim(os.Getenv("API_ENV"), "/"), strings.TrimLeft(path, "/"))
}

func Traverse[T interface{}](items *[]T, sub string, cb func(i int, item *T)) {
	for i, item := range *items {
		cb(i, &(*items)[i])
		if v, ok := StructHasFiled(item, sub); ok {
			if subList, ok := v.([]T); ok && len(subList) > 0 {
				Traverse(&subList, sub, cb)
			}
		}
	}
}

func StructHasFiled(obj interface{}, name string) (interface{}, bool) {
	t := reflect.ValueOf(obj)
	if t.Kind() == reflect.Ptr {
		t = t.Elem()
	}
	value := t.FieldByName(name)

	if !value.IsValid() {
		return nil, false
	}

	return value.Interface(), true
}

func Map[T interface{}](slice *[]T, cb func(i int, item *T)) {
	for i, _ := range *slice {
		cb(i, &(*slice)[i])
	}
}

func InArray[T comparable](arr []T, target T) bool {
	for _, v := range arr {
		if v == target {
			return true
		}
	}
	return false
}
