# Get All Frequencies

    GET frequency/list
    
Returns all the [Frequencies]

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

    GET https://hygieia.be/api/v1/frequency/list?page_size=2&sort=asc

### Response
``` json
{
    "data": [
        {
            "id": 12,
            "name": "1x 1/2 jaar",
            "created_at": "2019-11-05T17:10:15.000000Z",
            "updated_at": "2019-11-05T17:10:15.000000Z"
        },
        {
            "id": 11,
            "name": "1x 2 maanden",
            "created_at": "2019-11-05T17:10:05.000000Z",
            "updated_at": "2019-11-05T17:10:05.000000Z"
        }
    ],
    "links": {
        "first": "https://hygieia.be/api/v1/frequency/list?page=1",
        "last": "https://hygieia.be/api/v1/frequency/list?page=8",
        "prev": null,
        "next": "https://hygieia.be/api/v1/frequency/list?page=2"
    },
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 8,
        "path": "https://hygieia.be/api/v1/frequency/list",
        "per_page": 2,
        "to": 2,
        "total": 15
    },
    "version": "1.0.0",
    "status": "success",
    "code": 200,
    "valid_as_of": "Wed, 05 Aug 2020 00:30:21"
}
```

[Frequencies]: README.md