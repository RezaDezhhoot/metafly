package comment

import (
	"api/packages/v1/user"
	"gorm.io/gorm"
	"time"
)

type Comment struct {
	ID              uint      `gorm:"column:id;primaryKey" json:"id"`
	UserID          uint      `gorm:"column:user_id;type:BIGINT NOT NULL;index" json:"-"`
	CommentableType string    `gorm:"column:commentable_type;type:VARCHAR(255) NOT NULL;index" json:"-"`
	CommentableID   int       `gorm:"column:commentable_id;type:BIGINT NOT NULL;index" json:"-"`
	Status          string    `gorm:"column:status;type:VARCHAR(255) NOT NULL;index" json:"-"`
	IsAdmin         bool      `gorm:"column:is_admin;type:BOOLEAN NOT NULL" json:"is_admin"`
	Body            string    `gorm:"column:body;type:TEXT NOT NULL" json:"body"`
	ReplyOn         *uint     `gorm:"column:reply_on;type:BIGINT;index" json:"reply_on"`
	Likes           uint      `gorm:"column:likes;type:BIGINT NOT NULL;default:0" json:"likes"`
	CreatedAt       time.Time `gorm:"column:created_at" json:"created_at"`
	UpdatedAt       time.Time `gorm:"column:updated_at" json:"updated_at"`
	Parent          *Comment  `gorm:"foreignKey:ReplyOn;references:ID" json:"parent"`
	User            user.User `gorm:"foreignKey:UserID;references:ID" json:"user"`
	Replies         int       `gorm:"->" json:"replies"`
}

func (c Comment) TableName() string {
	return "comments"
}

func Published() func(DB *gorm.DB) *gorm.DB {
	return func(DB *gorm.DB) *gorm.DB {
		return DB.Where("status = ?", PUBLISHED)
	}
}

func WithParent() func(DB *gorm.DB) *gorm.DB {
	return func(DB *gorm.DB) *gorm.DB {
		return DB.Preload("Parent").Preload("Parent.User")
	}
}

func WithUser() func(DB *gorm.DB) *gorm.DB {
	return func(DB *gorm.DB) *gorm.DB {
		return DB.Preload("User")
	}
}

func WithRepliesCount() func(DB *gorm.DB) *gorm.DB {
	return func(DB *gorm.DB) *gorm.DB {
		return DB.Select("*,(SELECT COUNT(*) FROM comments c WHERE c.reply_on = comments.id AND c.commentable_type = ? AND c.status = ?) AS replies", "post", PUBLISHED)
	}
}
