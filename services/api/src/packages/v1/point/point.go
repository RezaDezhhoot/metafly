package point

import "time"

type Point struct {
	ID           uint          `gorm:"column:id;primaryKey" json:"id"`
	Country      string        `gorm:"column:country;type:VARCHAR(255) NOT NULL" json:"country"`
	City         string        `gorm:"column:city;type:VARCHAR(255) NOT NULL" json:"city"`
	Image        string        `gorm:"column:image;type:TEXT NOT NULL" json:"image"`
	CreatedAt    time.Time     `gorm:"column:created_at" json:"created_at"`
	UpdatedAt    time.Time     `gorm:"column:updated_at" json:"updated_at"`
	Objects      []ObjectPoint `gorm:"foreignKey:PointID;references:ID" json:"-"`
	ObjectsCount uint          `gorm:"->" json:"objects_count"`
	Title        *string       `gorm:"-" json:"title"`
}

func (p *Point) TableName() string {
	return "points"
}
