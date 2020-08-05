# Update Procedure By Id

    PUT procedure/{id}
    
Returns the updated [Procedure]

## Parameters
### URI Parameters
Field | Data Type | Required | Description
--- | --- | --- | ---
id | integer | Y | Unique identifier

### Body Parameters
Field | Data Type | Required | Description
--- | --- | --- | ---
name | string | Y | The procedure name
description | string | Y | 

## Example
### Request

    PUT https://hygieia.be/api/v1/procedure/5

#### Request Body
```json 
{
    "name": "poetsen detergent",
    "description": "Haal het recipiënt uit elkaar indien mogelijk.  Was de losse onderdelen in een oplossing van detergent.  Was de vaste onderdelen ook met een oplossing van detergent.  Spoel af met zuiver water.  Droog met een zuivere doek of aan de lucht."
}
```

### Response
``` json
{
    "data": {
        "id": 5,
        "name": "poetsen detergent",
        "description": "Haal het recipiënt uit elkaar indien mogelijk.  Was de losse onderdelen in een oplossing van detergent.  Was de vaste onderdelen ook met een oplossing van detergent.  Spoel af met zuiver water.  Droog met een zuivere doek of aan de lucht.",
        "created_at": "2019-11-06T10:33:57.000000Z",
        "updated_at": "2019-11-06T10:33:57.000000Z"
    },
    "version": "1.0.0",
    "status": "success",
    "code": 200,
    "valid_as_of": "Wed, 05 Aug 2020 00:48:23"
}
```

[Procedure]: README.md