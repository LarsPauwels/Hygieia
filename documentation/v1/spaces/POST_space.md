# Create Space By Client

    POST client/{id}/space
    
Returns the new created [Space] for a certain [Client]

## Parameters
### URI Parameters
Field | Data Type | Required | Description
--- | --- | --- | ---
id | integer | Y | Unique identifier

### Body Parameters
Field | Data Type | Required | Description
--- | --- | --- | ---
name | string | Y | The name of the space

## Example
### Request

    POST https://hygieia.be/api/v1/client/6/space

#### Request Body
```json 
{
    "name": "woonkamer"
}  
```

### Response
``` json
{
    "data": {
        "id": 145,
        "name": "woonkamer",
        "created_at": "2020-08-04T23:00:22.000000Z",
        "updated_at": "2020-08-04T23:00:22.000000Z"
    },
    "version": "1.0.0",
    "status": "success",
    "code": 200,
    "valid_as_of": "Tue, 04 Aug 2020 23:00:22"
}
```

[Space]: README.md
[Client]: ../clients/README.md