# Delete Client By Id

    DELETE client/{id}
    
Returns the deleted [Client]

## Parameters
### URI Parameters
Field | Data Type | Required | Description
--- | --- | --- | ---
id | integer | Y | Unique identifier

## Example
### Request

    DELETE https://hygieia.be/api/v1/client/40

### Response
``` json
{
    "data": {
        "id": 40,
        "name": "Company",
        "address": "4054  Haul Road, Saint Paul, Minnesota",
        "email": "company@gmail.com",
        "logo_path": "uploads/logos/company_1596312383.jpg",
        "created_at": "2020-08-01T15:31:32.000000Z",
        "updated_at": "2020-08-04T22:40:53.000000Z",
        "spaces": []
    },
    "version": "1.0.0",
    "status": "success",
    "code": 200,
    "valid_as_of": "Tue, 04 Aug 2020 22:42:34"
}
```

[Client]: README.md