package settings

import "time"

type Settings struct {
	ID        uint      `gorm:"column:id;primaryKey" json:"id"`
	Name      string    `gorm:"column:name;type:VARCHAR(255) NOT NULL" json:"name"`
	Value     *string   `gorm:"column:value;type:text" json:"value"`
	CreatedAt time.Time `gorm:"column:created_at" json:"created_at"`
	UpdatedAt time.Time `gorm:"column:updated_at" json:"updated_at"`
}

func (s *Settings) TableName() string {
	return "settings"
}
