# Delete Item By Id

    DELETE item/{id}
    
Returns the deleted [Item]

## Parameters
### URI Parameters
Field | Data Type | Required | Description
--- | --- | --- | ---
id | integer | Y | Unique identifier

## Example
### Request

    DELETE https://hygieia.be/api/v1/item/145

### Response
``` json
{
    "data": {
        "id": 1839,
        "name": "bain-marie",
        "created_at": "2020-08-04T23:19:09.000000Z",
        "updated_at": "2020-08-04T23:19:09.000000Z",
        "space": {
            "id": 145,
            "name": "woonkamer",
            "created_at": "2020-07-29T23:59:57.000000Z",
            "updated_at": "2020-07-29T23:59:57.000000Z"
        },
        "frequency": {
            "id": 5,
            "name": "3x per week",
            "created_at": null,
            "updated_at": null
        },
        "procedure": null,
        "icon": {
            "id": 5,
            "name": "bain marie",
            "image": "/uploads/images/bain-marie_1572970422.jpg",
            "type": "item",
            "created_at": "2019-11-05T17:13:42.000000Z",
            "updated_at": "2019-11-05T17:13:42.000000Z"
        }
    },
    "version": "1.0.0",
    "status": "success",
    "code": 200,
    "valid_as_of": "Tue, 04 Aug 2020 23:19:09"
}
```

[Item]: README.md