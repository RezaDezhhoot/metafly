package settings

import (
	"api/config"
	"api/helpers"
	"api/packages/v1/base"
	"encoding/json"
	"github.com/gin-gonic/gin"
)

func Find(c *gin.Context) {
	DB := config.GetPostgres()
	names := c.QueryArray("name")

	var results []Settings
	DB.Model(&Settings{}).Select("name", "value").Where("name IN ?", names).Find(&results)

	var mappedData = make(map[string]any)
	for _, i := range results {
		if i.Value != nil {
			if i.Name == "logo" {
				image := helpers.Asset(*i.Value)
				mappedData[i.Name] = &image
				continue
			}
			if json.Valid([]byte(*i.Value)) {
				var output any
				_ = json.Unmarshal([]byte(*i.Value), &output)
				mappedData[i.Name] = output
				continue
			}
		}

		mappedData[i.Name] = i.Value
	}
	c.JSON(200, base.GenerateBaseResponse(mappedData, true, 200, "", nil))
}
