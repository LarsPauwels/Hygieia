# Update Icon By Id

    POST icon/{id}
    
Returns the updated [Icon]

## Parameters
### URI Parameters
Field | Data Type | Required | Description
--- | --- | --- | ---
id | integer | Y | Unique identifier
_method | string | Y | To change your X (post) request to a Y (put) request (because of the image upload)

### Body Parameters
Field | Data Type | Required | Description
--- | --- | --- | ---
name | string | Y | The icon name
image | file | Y | An image of your icon (upload)
type | string | Y | The type of the icon (product or item)

## Example
### Request

    POST https://hygieia.be/api/v1/icon/1?_method=put

#### Request Body
```json 
{
    "name": "aanrecht",
    "image": "file.png (uploaded file)",
    "type": "item"
}  
```

### Response
``` json
{
    "data": {
        "id": 1,
        "name": "aanrecht",
        "image": "/uploads/images/aanrecht_1572970363.bmp",
        "type": "item",
        "created_at": "2019-11-05T17:12:43.000000Z",
        "updated_at": "2019-11-05T17:12:43.000000Z"
    },
    "version": "1.0.0",
    "status": "success",
    "code": 200,
    "valid_as_of": "Wed, 05 Aug 2020 00:39:57"
}
```

[Icon]: README.md