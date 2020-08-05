# GET All Products By User

    GET user/clients
    
Returns all [Clients] of a certain [user]

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

    GET https://hygieia.be/api/v1/user/clients?page_size=2&sort=ASC

### Response
``` json
{
    "data": [
        {
            "id": 18,
            "name": "Company",
            "address": "4054  Haul Road, Saint Paul, Minnesota",
            "email": "Jhon@doe.be",
            "logo_path": "/uploads/images/company_1578648211.jfif",
            "created_at": "2020-01-10T10:23:31.000000Z",
            "updated_at": "2020-01-10T10:23:31.000000Z",
            "spaces": [
                {
                    "id": 82,
                    "name": "winkelruimte",
                    "created_at": "2020-01-10T10:23:59.000000Z",
                    "updated_at": "2020-01-10T10:23:59.000000Z"
                }
            ]
        },
        {
            "id": 14,
            "name": "Company 2",
            "address": "2814  Thrash Trail, Deport, Texas",
            "email": "Jhon2@doe.be",
            "logo_path": "/uploads/images/Company2_1576831910.png",
            "created_at": "2019-12-20T09:51:50.000000Z",
            "updated_at": "2020-08-04T16:35:55.000000Z",
            "spaces": [
                {
                    "id": 64,
                    "name": "keuken",
                    "created_at": "2019-12-20T09:52:41.000000Z",
                    "updated_at": "2019-12-20T09:52:41.000000Z"
                },
                {
                    "id": 65,
                    "name": "verbruikzaal",
                    "created_at": "2019-12-20T09:52:49.000000Z",
                    "updated_at": "2019-12-20T09:52:49.000000Z"
                }
            ]
        }
    ],
    "links": {
        "first": "https://hygieia.be/api/v1/user/clients?page=1",
        "last": "https://hygieia.be/api/v1/user/clients?page=29",
        "prev": null,
        "next": "https://hygieia.be/api/v1/user/clients?page=2"
    },
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 29,
        "path": "https://hygieia.be/api/v1/user/clients",
        "per_page": 2,
        "to": 2,
        "total": 57
    },
    "version": "1.0.0",
    "status": "success",
    "code": 200,
    "valid_as_of": "Tue, 04 Aug 2020 22:19:24"
}
```

[user]: README.md
[Clients]: ../clients/README.md