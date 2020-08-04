# Get All Users

    GET user/list
    
Returns all the [Accounts]

## Parameters
### URI Parameters
Field | Data Type | Required | Description
--- | --- | --- | ---
page | integer | N | The page number in the result set to return (default 1)
page_size | integer | N | The number of records to return per page (default 50, max 200)
sort | integer | N | asc (default) or desc
search | integer | N | Search by the name field

## Example
### Request

    GET https://hygieia.be/api/v1/user/list?page_size=2&sort=ASC

### Response
``` json
{
    "data": [
        {
            "id": 26,
            "name": "Jhon Doe",
            "email": "Jhon@doe.be",
            "created_at": "2020-08-04T19:49:51.000000Z",
            "updated_at": "2020-08-04T21:14:07.000000Z",
            "deleted_at": null
        },
        {
            "id": 1,
            "name": "Jhon Doe",
            "email": "Jhon@doe.be",
            "created_at": "2020-08-04T19:49:51.000000Z",
            "updated_at": "2020-08-04T21:14:07.000000Z",
            "deleted_at": null
        }
    ],
    "links": {
        "first": "https://hygieia.be/api/v1/user/list?page=1",
        "last": "https://hygieia.be/api/v1/user/list?page=3",
        "prev": null,
        "next": "https://hygieia.be/api/v1/user/list?page=2"
    },
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 3,
        "path": "http://foodapp.test/api/v1/user/list",
        "per_page": 2,
        "to": 2,
        "total": 5
    },
    "version": "1.0.0",
    "status": "success",
    "code": 200,
    "valid_as_of": "Tue, 04 Aug 2020 21:22:57"
}
```

[Accounts]: README.md