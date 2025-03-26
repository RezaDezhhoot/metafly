package category

import (
	"gorm.io/gorm"
	"time"
)

type Category struct {
	ID        uint       `gorm:"column:id;primaryKey" json:"id"`
	Slug      string     `gorm:"column:slug;type:VARCHAR(255) NOT NULL;unique_index" json:"slug"`
	Title     string     `gorm:"column:title;type:VARCHAR(255) NOT NULL" json:"title"`
	Image     *string    `gorm:"column:image;type:text" json:"image"`
	Type      string     `gorm:"column:type;type:VARCHAR(255) NOT NULL" json:"type"`
	ParentID  *uint      `gorm:"column:parent_id;type:BIGINT;index" json:"-"`
	Parent    *Category  `gorm:"foreignKey:ParentID" json:"parent"`
	Children  []Category `gorm:"foreignKey:ParentID" json:"children"`
	CreatedAt time.Time  `gorm:"column:created_at" json:"created_at"`
	UpdatedAt time.Time  `gorm:"column:updated_at" json:"updated_at"`
}

func (c *Category) TableName() string {
	return "categories"
}

func WithParent() func(db *gorm.DB) *gorm.DB {
	return func(db *gorm.DB) *gorm.DB {
		return db.Preload("Parent")
	}
}

func WithChildren() func(db *gorm.DB) *gorm.DB {
	return func(db *gorm.DB) *gorm.DB {
		return db.Preload("Children")
	}
}
