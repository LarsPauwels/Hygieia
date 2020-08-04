# Forgot Password By Email

    PUT forgot
    
Updates the password and returns a single [Account] <br>
Also sends an email with a token to recover your password

## Parameters
### Body Parameters
Field | Data Type | Required | Description
--- | --- | --- | ---
email | string | Y | 

## Example
### Request

    PUT https://hygieia.be/api/v1/forgot

#### Request Body
```json 
{
    "email": "Jhon@doe.be"
}   
```

### Response
``` json
{
    "data": {
        "id": 26,
        "name": "Jhon Doe",
        "email": "Jhon@doe.be",
        "created_at": "2020-08-04T19:49:51.000000Z",
        "updated_at": "2020-08-04T21:14:07.000000Z",
        "deleted_at": null
    },
    "version": "1.0.0",
    "status": "success",
    "code": 200,
    "valid_as_of": "Tue, 04 Aug 2020 21:14:08"
}
```

[Account]: README.md