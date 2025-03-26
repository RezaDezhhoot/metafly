package user

import "time"

type User struct {
	ID              uint       `gorm:"column:id;primaryKey" json:"id"`
	Name            string     `gorm:"column:name;type:VARCHAR(255) NOT NULL"`
	Email           string     `gorm:"column:email;type:VARCHAR(255) NOT NULL;unique_index" json:"-"`
	PhoneVerifiedAt *time.Time `gorm:"column:phone_verified_at;type:TIMESTAMP" json:"-"`
	Password        string     `gorm:"column:password;type:VARCHAR(255)" json:"-"`
	RememberToken   *string    `gorm:"column:remember_token;type:VARCHAR(255)" json:"-"`
	Image           *string    `gorm:"column:image;type:VARCHAR(255)" json:"image"`
	Phone           *string    `gorm:"column:phone;type:VARCHAR(255);unique_index" json:"-"`
	CreatedAt       time.Time  `gorm:"column:created_at" json:"-"`
	UpdatedAt       time.Time  `gorm:"column:updated_at" json:"-"`
}

func (u *User) TableName() string {
	return "users"
}
