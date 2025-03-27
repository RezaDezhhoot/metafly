package topic

type Topicables struct {
	ID            uint   `gorm:"column:id;primaryKey" json:"id"`
	TopicID       uint   `gorm:"column:topic_id;type:BIGINT NOT NULL;index" json:"-"`
	TopicableType string `gorm:"column:topicable_type;type:VARCHAR(255) NOT NULL;index" json:"-"`
	TopicableID   string `gorm:"column:topicable_id;type:BIGINT NOT NULL;index" json:"-"`
	Topic         Topic  `gorm:"foreignKey:TopicID;references:ID" json:"topic"`
}

func (t *Topicables) TableName() string {
	return "topicables"
}
