# Delete Product By Id

    DELETE product/{id}
    
Returns the deleted [Product]

## Parameters
### URI Parameters
Field | Data Type | Required | Description
--- | --- | --- | ---
id | integer | Y | Unique identifier

## Example
### Request

    DELETE https://hygieia.be/api/v1/product/73

### Response
``` json
{
    "data": {
        "id": 73,
        "name": "ajax floral fiesta",
        "quantity": "1 dopje",
        "information": "uploads/info/test_1596586449.pdf",
        "icon": {
            "id": 1,
            "name": "aanrecht",
            "image": "/uploads/images/aanrecht_1572970363.bmp",
            "type": "item",
            "created_at": "2019-11-05T17:12:43.000000Z",
            "updated_at": "2019-11-05T17:12:43.000000Z"
        },
        "created_at": "2020-08-05T00:14:09.000000Z",
        "updated_at": "2020-08-05T00:14:09.000000Z"
    },
    "version": "1.0.0",
    "status": "success",
    "code": 200,
    "valid_as_of": "Wed, 05 Aug 2020 00:14:09"
}
```

[Product]: README.md