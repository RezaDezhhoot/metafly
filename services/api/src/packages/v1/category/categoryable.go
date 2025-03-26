package category

type Categoryable struct {
	ID               uint     `gorm:"column:id;primaryKey" json:"id"`
	CategoryID       uint     `gorm:"column:category_id;type:BIGINT;index" json:"-"`
	CategoryableType string   `gorm:"column:categoryable_type;type:VARCHAR(255);index" json:"-"`
	CategoryableID   string   `gorm:"column:categoryable_id;type:BIGINT;index" json:"-"`
	Category         Category `gorm:"foreignKey:CategoryID;references:ID" json:"category"`
}

func (c *Categoryable) TableName() string {
	return "categoryables"
}
