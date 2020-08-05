# Get All Procedures

    GET procedure/list
    
Returns all the [Procedures]

## Parameters
### URI Parameters
Field | Data Type | Required | Description
--- | --- | --- | ---
page | integer | N | The page number in the result set to return (default 1)
page_size | integer | N | The number of records to return per page (default 50, max 200)
sort | integer | N | asc (default) or desc
search | integer | N | Search by the name field

## Example
### Request

    GET https://hygieia.be/api/v1/procedure/list?page_size=2&sort=asc

### Response
``` json
{
    "data": [
        {
            "id": 16,
            "name": "afstoffen",
            "description": "Item vrijmaken van obstakels, meteen plumeau of doek afstoffen.\r\nVergeet ook iet de hoekjes en kantjes mee af te stoffen en de verborgen niet voor de hand liggende delen zoals vloerplinten, enz....",
            "created_at": "2020-01-17T13:00:41.000000Z",
            "updated_at": "2020-01-17T13:00:41.000000Z"
        },
        {
            "id": 8,
            "name": "desinfecteren",
            "description": "Neem het vuil weg en zet het recipiënt in met een oplossing van desinfectant.  Laat minimaal 5 minuten inweken.  Neem de oplossing weg met zuiver water en droog met een zuiver doek of laat aan de lucht drogen.",
            "created_at": "2019-11-06T10:38:32.000000Z",
            "updated_at": "2019-11-06T10:38:32.000000Z"
        }
    ],
    "links": {
        "first": "https://hygieia.be/api/v1/procedure/list?page=1",
        "last": "https://hygieia.be/api/v1/procedure/list?page=6",
        "prev": null,
        "next": "https://hygieia.be/api/v1/procedure/list?page=2"
    },
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 6,
        "path": "https://hygieia.be/api/v1/procedure/list",
        "per_page": 2,
        "to": 2,
        "total": 11
    },
    "version": "1.0.0",
    "status": "success",
    "code": 200,
    "valid_as_of": "Wed, 05 Aug 2020 00:47:12"
}
```

[Procedures]: README.md