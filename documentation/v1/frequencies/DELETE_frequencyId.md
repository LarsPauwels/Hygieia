# Delete Frequency By Id

    DELETE frequency/{id}
    
Returns the deleted [Frequency]

## Parameters
### URI Parameters
Field | Data Type | Required | Description
--- | --- | --- | ---
id | integer | Y | Unique identifier

## Example
### Request

    DELETE https://hygieia.be/api/v1/frequency/1

### Response
``` json
{
    "data": {
        "id": 1,
        "name": "dagelijks",
        "created_at": null,
        "updated_at": "2020-07-28T23:49:20.000000Z"
    },
    "version": "1.0.0",
    "status": "success",
    "code": 200,
    "valid_as_of": "Wed, 05 Aug 2020 00:32:58"
}
```

[Frequency]: README.md