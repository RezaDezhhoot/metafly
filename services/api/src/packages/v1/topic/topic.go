package topic

import "time"

type Topic struct {
	ID        uint      `gorm:"column:id;primaryKey" json:"id"`
	Title     string    `gorm:"column:title;type:VARCHAR(255) NOT NULL" json:"title"`
	CreatedAt time.Time `gorm:"column:created_at" json:"-"`
	UpdatedAt time.Time `gorm:"column:updated_at" json:"-"`
}

func (t *Topic) TableName() string {
	return "topics"
}
