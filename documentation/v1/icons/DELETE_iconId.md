# Delete Icon By Id

    DELETE icon/{id}
    
Returns the deleted [Icon]

## Parameters
### URI Parameters
Field | Data Type | Required | Description
--- | --- | --- | ---
id | integer | Y | Unique identifier

## Example
### Request

    DELETE https://hygieia.be/api/v1/icon/1

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