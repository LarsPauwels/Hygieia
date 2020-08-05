# Get Item By Id

    GET item/{id}
    
Returns a single [Item]

## Parameters
### URI Parameters
Field | Data Type | Required | Description
--- | --- | --- | ---
id | integer | Y | Unique identifier

## Example
### Request

    GET https://hygieia.be/api/v1/item/875

### Response
``` json
{
    "data": {
        "id": 875,
        "name": "plafond",
        "created_at": "2019-12-27T10:47:02.000000Z",
        "updated_at": "2019-12-27T10:47:02.000000Z",
        "space": {
            "id": 74,
            "name": "voorraadplaats",
            "created_at": "2019-12-27T10:38:51.000000Z",
            "updated_at": "2019-12-27T10:38:51.000000Z"
        },
        "frequency": {
            "id": 12,
            "name": "1x 1/2 jaar",
            "created_at": "2019-11-05T17:10:15.000000Z",
            "updated_at": "2019-11-05T17:10:15.000000Z"
        },
        "procedure": null,
        "icon": {
            "id": 61,
            "name": "plafond",
            "image": "/uploads/images/plafond_1572971579.bmp",
            "type": "item",
            "created_at": "2019-11-05T17:32:59.000000Z",
            "updated_at": "2019-11-05T17:32:59.000000Z"
        }
    },
    "version": "1.0.0",
    "status": "success",
    "code": 200,
    "valid_as_of": "Tue, 04 Aug 2020 23:14:12"
}
```

[Item]: README.md