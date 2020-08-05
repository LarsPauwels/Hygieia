# Update Client Expired

    PUT client/{id}/expired
    
Returns the updated [Client] and soft deleted the client in the [User] object

## Parameters
### URI Parameters
Field | Data Type | Required | Description
--- | --- | --- | ---
id | integer | Y | Unique identifier

## Example
### Request

    PUT https://hygieia.be/api/v1/client/16/expired

### Response
``` json
{
    "data": {
        "id": 26,
        "name": "Company",
        "email": "Company@gmail.com",
        "address": "4054  Haul Road, Saint Paul, Minnesota",
        "logo_path": "/uploads/images/company_1577438757.jfif",
        "expires_at": "2019-11-06 00:00:00",
        "created_at": "2020-08-04T19:49:51.000000Z",
        "updated_at": "2020-08-04T19:49:51.000000Z",
        "deleted_at": null
    },
    "version": "1.0.0",
    "status": "success",
    "code": 200,
    "valid_as_of": "Tue, 04 Aug 2020 19:49:52"
}
```

[Client]: README.md
[User]: ../users/README.md