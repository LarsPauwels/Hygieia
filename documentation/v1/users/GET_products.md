# GET All Products By User

    GET user/products
    
Returns all [Products] of a certain [user]

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

    GET https://hygieia.be/api/v1/user/products?page_size=2&sort=ASC

### Response
``` json
{
    "data": [
        {
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
        {
            "id": 33,
            "name": "ajax optimal 7 limoen",
            "quantity": "2 doppen per 5L water \r\nhardnekkig vuil rechtstreeks gebruik",
            "icon": {
                "id": 136,
                "name": "AJAX groen optimal 7",
                "image": "/uploads/images/ajax-groen-optimal-7_1576598020.jpg",
                "type": "product",
                "created_at": "2019-12-17T16:53:40.000000Z",
                "updated_at": "2019-12-17T16:53:40.000000Z"
            },
            "created_at": "2019-12-17T16:57:33.000000Z",
            "updated_at": "2019-12-17T16:57:33.000000Z"
        }
    ],
    "links": {
        "first": "https://hygieia.be/api/v1/user/products?page=1",
        "last": "https://hygieia.be/api/v1/user/products?page=31",
        "prev": null,
        "next": "https://hygieia.be/api/v1/user/products?page=2"
    },
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 31,
        "path": "https://hygieia.bet/api/v1/user/products",
        "per_page": 2,
        "to": 2,
        "total": 61
    },
    "version": "1.0.0",
    "status": "success",
    "code": 200,
    "valid_as_of": "Tue, 04 Aug 2020 22:23:44"
}
```

[user]: README.md
[Products]: ../products/README.md