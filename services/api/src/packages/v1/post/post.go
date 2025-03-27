package post

import (
	"api/packages/v1/category"
	"api/packages/v1/topic"
	"api/packages/v1/user"
	"gorm.io/gorm"
	"time"
)

type Post struct {
	ID             uint                    `gorm:"column:id;primaryKey" json:"id"`
	Slug           string                  `gorm:"column:slug;type:VARCHAR(255) NOT NULL;unique_index" json:"slug"`
	Title          string                  `gorm:"column:title;type:VARCHAR(255) NOT NULL" json:"title"`
	UserID         uint                    `gorm:"column:user_id;type:BIGINT NOT NULL;index'" json:"-"`
	SubTitle       *string                 `gorm:"column:sub_title;type:VARCHAR(255)" json:"sub_title"`
	StudyTime      *uint                   `gorm:"column:study_time;type:INT" json:"study_time"`
	Content        *string                 `gorm:"column:content;type:TEXT" json:"-"`
	Image          string                  `gorm:"column:image;type:text NOT NULL" json:"image"`
	Views          uint                    `gorm:"column:views;type:BIGINT NOT NULL;default:0" json:"views"`
	Status         string                  `gorm:"column:status;type:VARCHAR(255) NOT NULL;index" json:"-"`
	SeoKeywords    *string                 `gorm:"column:seo_keywords;type:text" json:"seo_keywords,omitempty"`
	SeoDescription *string                 `gorm:"column:seo_description;type:text" json:"seo_description,omitempty"`
	Slider         bool                    `gorm:"column:slider;type:BOOLEAN;default:false" json:"slider"`
	Author         user.User               `gorm:"foreignKey:UserID;references:ID" json:"author"`
	CreatedAt      time.Time               `gorm:"column:created_at" json:"created_at"`
	UpdatedAt      time.Time               `gorm:"column:updated_at" json:"updated_at"`
	Categories     []category.Categoryable `gorm:"polymorphicType:CategoryableType;polymorphicId:CategoryableID;polymorphicValue:post" json:"categories"`
	Topics         []topic.Topicables      `gorm:"polymorphicType:TopicableType;polymorphicId:TopicableID;polymorphicValue:post" json:"topics"`
	ContentWrapped any                     `gorm:"-:all" json:"content,omitempty"`
}

func (p *Post) TableName() string {
	return "posts"
}

func Published() func(DB *gorm.DB) *gorm.DB {
	return func(DB *gorm.DB) *gorm.DB {
		return DB.Where("status = ?", PUBLISHED)
	}
}

func Summary() func(DB *gorm.DB) *gorm.DB {
	return func(DB *gorm.DB) *gorm.DB {
		return DB.Select("posts.id,title,slug,image,sub_title,user_id,slider,study_time,views,created_at,updated_at")
	}
}

func WithCategories() func(DB *gorm.DB) *gorm.DB {
	return func(DB *gorm.DB) *gorm.DB {
		return DB.Preload("Categories").
			Preload("Categories.Category").
			Preload("Categories.Category.Parent")
	}
}

func WithTopics() func(DB *gorm.DB) *gorm.DB {
	return func(DB *gorm.DB) *gorm.DB {
		return DB.Preload("Topics").Preload("Topics.Topic")
	}
}

func WithAuthor() func(DB *gorm.DB) *gorm.DB {
	return func(DB *gorm.DB) *gorm.DB {
		return DB.Preload("Author")
	}
}
