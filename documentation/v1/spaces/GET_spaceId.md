# Get Space By Id

    GET space/{id}
    
Returns a single [Space]

## Parameters
### URI Parameters
Field | Data Type | Required | Description
--- | --- | --- | ---
id | integer | Y | Unique identifier

## Example
### Request

    GET https://hygieia.be/api/v1/space/40

### Response
``` json
{
    "data": {
        "id": 40,
        "name": "magazijn boven",
        "created_at": "2019-12-11T14:11:48.000000Z",
        "updated_at": "2019-12-11T14:11:48.000000Z"
    },
    "version": "1.0.0",
    "status": "success",
    "code": 200,
    "valid_as_of": "Tue, 04 Aug 2020 22:52:05"
}
```

[Space]: README.md