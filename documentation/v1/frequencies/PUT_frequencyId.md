# Update Frequency By Id

    PUT frequency/{id}
    
Returns the updated [Frequency]

## Parameters
### URI Parameters
Field | Data Type | Required | Description
--- | --- | --- | ---
id | integer | Y | Unique identifier

### Body Parameters
Field | Data Type | Required | Description
--- | --- | --- | ---
name | string | Y | The frequency name

## Example
### Request

    PUT https://hygieia.be/api/v1/frequency/1

#### Request Body
```json 
{
    "name": "dagelijks"
} 
```

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