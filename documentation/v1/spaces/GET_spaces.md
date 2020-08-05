# Get All Spaces By User

    GET client/{id}/space/list
    
Returns all the [Spaces] for a certain [Client]

## Parameters
### URI Parameters
Field | Data Type | Required | Description
--- | --- | --- | ---
id | integer | Y | Unique identifier
page | integer | N | The page number in the result set to return (default 1)
page_size | integer | N | The number of records to return per page (default 50, max 200)
sort | integer | N | asc (default) or desc
search | integer | N | Search by the name field

## Example
### Request

    GET https://hygieia.be/api/v1/client/4/space/list?page_size=2&sort=asc

### Response
``` json
{
    "data": {
        "id": 4,
        "name": "Company",
        "address": "4054  Haul Road, Saint Paul, Minnesota",
        "email": "company@gmail.com",
        "logo_path": "/uploads/images/company_1575461561.jfif",
        "created_at": "2019-11-06T18:14:18.000000Z",
        "updated_at": "2019-12-04T13:12:41.000000Z",
        "spaces": [
            {
                "id": 58,
                "name": "diepvriesruimte",
                "created_at": "2019-12-18T13:34:29.000000Z",
                "updated_at": "2019-12-18T13:34:29.000000Z"
            },
            {
                "id": 59,
                "name": "feestzaal",
                "created_at": "2019-12-18T13:44:01.000000Z",
                "updated_at": "2019-12-18T13:44:01.000000Z"
            }
        ]
    },
    "version": "1.0.0",
    "status": "success",
    "code": 200,
    "valid_as_of": "Tue, 04 Aug 2020 22:27:01"
}
```

[Spaces]: README.md
[Client]: ../clients/README.md