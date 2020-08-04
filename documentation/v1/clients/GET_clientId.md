# Get Client By Id

    GET client/{id}
    
Returns a single [Client]

## Parameters
### URI Parameters
Field | Data Type | Required | Description
--- | --- | --- | ---
id | integer | Y | Unique identifier

## Example
### Request

    GET https://hygieia.be/api/v1/client/15

### Response
``` json
{
    "data": {
        "id": 15,
        "name": "Company",
        "address": "4054  Haul Road, Saint Paul, Minnesota",
        "email": "Company@gmail.com",
        "logo_path": "/uploads/images/company_1577091029.png",
        "created_at": "2019-12-23T09:50:29.000000Z",
        "updated_at": "2020-08-04T16:35:57.000000Z",
        "spaces": [
            {
                "id": 68,
                "name": "Keuken",
                "created_at": "2019-12-23T09:50:53.000000Z",
                "updated_at": "2019-12-23T09:50:53.000000Z"
            },
            {
                "id": 70,
                "name": "restaurant",
                "created_at": "2019-12-23T09:51:11.000000Z",
                "updated_at": "2019-12-23T09:51:11.000000Z"
            },
            {
                "id": 71,
                "name": "voorraad plaats",
                "created_at": "2019-12-23T09:51:57.000000Z",
                "updated_at": "2019-12-23T09:51:57.000000Z"
            }
        ]
    },
    "version": "1.0.0",
    "status": "success",
    "code": 200,
    "valid_as_of": "Tue, 04 Aug 2020 22:31:22"
}
```

[Client]: README.md