# Create Client

    POST client
    
Returns the new created [Client]

## Parameters
### Body Parameters
Field | Data Type | Required | Description
--- | --- | --- | ---
name | string | Y | Company name
address | string | Y | The address of your company
email | string | Y | 
logo | file | Y | An image of your logo (upload)

## Example
### Request

    POST https://hygieia.be/api/v1/client

#### Request Body
```json 
{
    "name": "Company",
    "address": "4054  Haul Road, Saint Paul, Minnesota",
    "email": "Company@gmail.com",
    "logo": "file.png (uploaded file)"
}  
```

### Response
``` json
{
    "data": {
        "id": 75,
        "name": "Company",
        "address": "4054  Haul Road, Saint Paul, Minnesota",
        "email": "Company@gmail.com",
        "logo_path": "uploads/logos/company_1596580540.png",
        "created_at": "2020-08-04T22:35:40.000000Z",
        "updated_at": "2020-08-04T22:35:40.000000Z",
        "spaces": []
    },
    "version": "1.0.0",
    "status": "success",
    "code": 200,
    "valid_as_of": "Tue, 04 Aug 2020 22:35:41"
}
```

[Client]: README.md