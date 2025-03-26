package config

import "github.com/go-playground/validator/v10"

var v *validator.Validate

func InitValidation() {
	v = validator.New(validator.WithPrivateFieldValidation())
}

func Validator() *validator.Validate {
	return v
}
