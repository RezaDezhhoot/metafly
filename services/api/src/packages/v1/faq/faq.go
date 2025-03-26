package faq

import "time"

type FAQ struct {
	ID        uint      `gorm:"column:id;primaryKey" json:"id"`
	Question  string    `gorm:"column:question;type:text" json:"question"`
	Answer    string    `gorm:"column:answer;type:text" json:"answer"`
	CreatedAt time.Time `gorm:"column:created_at" json:"created_at"`
	UpdatedAt time.Time `gorm:"column:updated_at" json:"updated_at"`
}

func (f *FAQ) TableName() string {
	return "faq"
}
