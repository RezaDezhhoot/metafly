package base

import (
	"github.com/gin-gonic/gin"
	"math"
	"strconv"
)

type Pagination struct {
	perPage     int
	page        int
	pageName    string
	perPageName string
}

type PaginationOption func(p *Pagination)

func NewPagination(c *gin.Context, options ...PaginationOption) *Pagination {
	p := &Pagination{}
	for _, option := range options {
		option(p)
	}

	perPageName := "per_page"
	if p.perPageName != "" {
		perPageName = p.perPageName
	}
	perPage, err := strconv.Atoi(c.Query(perPageName))
	if (err != nil || perPage <= 0) && p.perPage <= 0 {
		p.perPage = 10
	} else if err == nil && perPage > 0 {
		p.perPage = perPage
	}

	pageName := "page"
	if p.pageName != "" {
		perPageName = p.pageName
	}

	page, err := strconv.Atoi(c.Query(pageName))
	if err != nil || page <= 0 {
		page = 1
	}
	p.page = page

	return p
}

func (p *Pagination) Page() int {
	return p.page
}

func (p *Pagination) PerPage() int {
	return p.perPage
}

func (p *Pagination) Offset() int {
	return (p.page - 1) * p.perPage
}

func (p *Pagination) LastPage(total float64) float64 {
	return math.Ceil(total / float64(p.perPage))
}

func WithPerPage(perPage int) PaginationOption {
	return func(p *Pagination) {
		p.perPage = perPage
	}
}

func WithPageName(name string) PaginationOption {
	return func(p *Pagination) {
		p.pageName = name
	}
}

func WithPerPageName(name string) PaginationOption {
	return func(p *Pagination) {
		p.perPageName = name
	}
}
