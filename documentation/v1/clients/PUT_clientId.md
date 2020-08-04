# Update Client By Id

    POST client/{id}
    
Returns the updated [Client]

## Parameters
### URI Parameters
Field | Data Type | Required | Description
--- | --- | --- | ---
id | integer | Y | Unique identifier
_method | string | Y | To change your X (post) request to a Y (put) request (because of the image upload)

### Body Parameters
Field | Data Type | Required | Description
--- | --- | --- | ---
name | string | Y | Company name
address | string | Y | The address of your company
email | string | Y | 
logo | string | Y | An image of your logo (upload)

## Example
### Request

    POST https://hygieia.be/api/v1/client/40?_method=put

### Response
``` json
{
    "data": {
        "id": 40,
        "name": "Company",
        "address": "4054  Haul Road, Saint Paul, Minnesota",
        "email": "Company@gmail.com",
        "logo_path": "uploads/logos/company_1596312383.jpg",
        "created_at": "2020-08-01T15:31:32.000000Z",
        "updated_at": "2020-08-04T22:40:53.000000Z",
        "spaces": []
    },
    "version": "1.0.0",
    "status": "success",
    "code": 200,
    "valid_as_of": "Tue, 04 Aug 2020 22:40:53"
}
```

[Client]: README.md