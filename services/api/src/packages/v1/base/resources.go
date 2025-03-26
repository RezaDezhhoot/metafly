package base

import (
	"errors"
	"github.com/go-playground/validator/v10"
)

type Response struct {
	Result           any                `json:"result,omitempty"`
	Success          bool               `json:"success,omitempty"`
	Status           int                `json:"status,omitempty"`
	Message          string             `json:"message,omitempty"`
	ValidationErrors *[]validationError `json:"validationErrors,omitempty"`
	Error            any                `json:"error,omitempty"`
	Meta             *MetaData          `json:"meta,omitempty"`
}

type MetaData struct {
	CurrentPage int     `json:"current_page"`
	PerPage     int     `json:"per_page"`
	LastPage    float64 `json:"last_page"`
	Total       int64   `json:"total"`
	ExtraData   `json:"extra,omitempty"`
}

type ExtraData map[string]any

type validationError struct {
	Field   string `json:"field"`
	Tag     string `json:"tag"`
	Param   string `json:"param"`
	Message string `json:"message"`
}

func GenerateBaseResponse(result any, success bool, status int, message string, meta *MetaData) *Response {
	return &Response{
		Result:  result,
		Message: message,
		Success: success,
		Status:  status,
		Meta:    meta,
	}
}

func GenerateBaseResponseWithError(result any, success bool, status int, err error) *Response {
	return &Response{
		Result:  result,
		Success: success,
		Status:  status,
		Error:   err.Error(),
	}
}

func ValidationError(result any, success bool, status int, err error) *Response {
	return &Response{
		Result:           result,
		Success:          success,
		Status:           status,
		ValidationErrors: getValidationErrors(err),
	}
}

func getValidationErrors(error error) *[]validationError {
	var errorList []validationError
	if _, ok := error.(*validator.InvalidValidationError); ok {
		return nil
	}
	var ve validator.ValidationErrors

	if errors.As(error, &ve) {
		for _, err := range error.(validator.ValidationErrors) {
			e := validationError{
				Field:   err.Field(),
				Tag:     err.Tag(),
				Param:   err.Param(),
				Message: err.Error(),
			}
			errorList = append(errorList, e)
		}
	}
	return &errorList
}
