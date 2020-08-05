# Get Product By Id

    GET product/{id}
    
Returns a single [Product]

## Parameters
### URI Parameters
Field | Data Type | Required | Description
--- | --- | --- | ---
id | integer | Y | Unique identifier

## Example
### Request

    GET https://hygieia.be/api/v1/product/58

### Response
``` json
{
    "data": {
        "id": 58,
        "name": "ajax floral fiesta",
        "quantity": "1% (1/100)",
        "icon": {
            "id": 163,
            "name": "ajax floral fiesta",
            "image": "/uploads/images/ajax-floral-fiesta_1591444291.jpg",
            "type": "product",
            "created_at": "2020-06-06T13:51:31.000000Z",
            "updated_at": "2020-06-06T13:51:31.000000Z"
        },
        "created_at": "2020-06-06T13:54:08.000000Z",
        "updated_at": "2020-06-06T13:54:08.000000Z"
    },
    "version": "1.0.0",
    "status": "success",
    "code": 200,
    "valid_as_of": "Wed, 05 Aug 2020 00:08:53"
}
```

[Product]: README.md