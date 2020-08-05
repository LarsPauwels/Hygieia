# Create Frequency

    POST frequency
    
Returns the new created [Frequency]

## Parameters
### Body Parameters
Field | Data Type | Required | Description
--- | --- | --- | ---
name | string | Y | The frequency name

## Example
### Request

    POST https://hygieia.be/api/v1/frequency

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