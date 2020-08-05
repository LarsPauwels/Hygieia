# Get All Icons

    GET icon/list
    
Returns all the [Icons]

## Parameters
### URI Parameters
Field | Data Type | Required | Description
--- | --- | --- | ---
page | integer | N | The page number in the result set to return (default 1)
page_size | integer | N | The number of records to return per page (default 50, max 200)
sort | integer | N | asc (default) or desc
search | integer | N | Search by the name field
type | string | N | To get only the icons with type item or product (default all)

## Example
### Request

    GET https://hygieia.be/api/v1/icon/list?page_size=2&sort=asc&type=item

### Response
``` json
{
    "data": [
        {
            "id": 16,
            "name": "(opberg) boxen",
            "image": "/uploads/images/opberg-boxen_1572970679.jpg",
            "type": "item",
            "created_at": "2019-11-05T17:17:59.000000Z",
            "updated_at": "2019-11-05T17:17:59.000000Z"
        },
        {
            "id": 1,
            "name": "aanrecht",
            "image": "/uploads/images/aanrecht_1572970363.bmp",
            "type": "item",
            "created_at": "2019-11-05T17:12:43.000000Z",
            "updated_at": "2019-11-05T17:12:43.000000Z"
        }
    ],
    "links": {
        "first": "https://hygieia.be/api/v1/icon/list?page=1",
        "last": "https://hygieia.be/api/v1/icon/list?page=55",
        "prev": null,
        "next": "https://hygieia.be/api/v1/icon/list?page=2"
    },
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 55,
        "path": "https://hygieia.be/api/v1/icon/list",
        "per_page": 2,
        "to": 2,
        "total": 110
    },
    "version": "1.0.0",
    "status": "success",
    "code": 200,
    "valid_as_of": "Wed, 05 Aug 2020 00:37:34"
}
```

[Icons]: README.md