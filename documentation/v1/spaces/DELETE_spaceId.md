# Delete Space By Id

    DELETE space/{id}
    
Returns the deleted [Space]

## Parameters
### URI Parameters
Field | Data Type | Required | Description
--- | --- | --- | ---
id | integer | Y | Unique identifier

## Example
### Request

    DELETE https://hygieia.be/api/v1/space/1839

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