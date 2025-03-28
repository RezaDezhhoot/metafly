package point

type ObjectPoint struct {
	ID         uint   `gorm:"column:id;primaryKey" json:"id"`
	PointID    uint   `gorm:"point_id;type:BIGINT NOT NULL" json:"-"`
	ObjectType string `gorm:"column:object_type;type:VARCHAR(255);index" json:"-"`
	ObjectID   string `gorm:"column:object_id;type:BIGINT;index" json:"-"`
	Point      Point  `gorm:"foreignKey:PointID;references:ID" json:"point"`
}

func (o *ObjectPoint) TableName() string {
	return "object_points"
}
