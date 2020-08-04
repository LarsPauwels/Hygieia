# Login

    POST login
    
Returns a single [Account] and logs the user in

## Parameters
### Body Parameters
Field | Data Type | Required | Description
--- | --- | --- | ---
email | string | Y | 
password | string | Y | 
remember | boolean | Y | If you want to login automatically or not

## Example
### Request

    POST https://hygieia.be/api/v1/login

#### Request Body
```json 
{
    "email": "Jhon@doe.com",
    "password": "password123",
    "remember": true
}   
```

### Response
``` json
{
    "data": {
        "user": {
            "id": 26,
            "name": "Jhon Doe",
            "email": "Jhon@doe.be",
            "created_at": "2020-08-04T19:49:51.000000Z",
            "updated_at": "2020-08-04T20:10:48.000000Z",
            "deleted_at": null
        },
        "token": "..."
    },
    "version": "1.0.0",
    "status": "success",
    "code": 200,
    "valid_as_of": "Tue, 04 Aug 2020 20:10:58"
}
```

[Account]: README.md
