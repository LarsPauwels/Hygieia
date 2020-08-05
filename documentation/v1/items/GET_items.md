# Get All Items By Space

    GET space/{id}/item/list
    
Returns all the [Items] for a certain [Space]

## Parameters
### URI Parameters
Field | Data Type | Required | Description
--- | --- | --- | ---
id | integer | Y | Unique identifier
page | integer | N | The page number in the result set to return (default 1)
page_size | integer | N | The number of records to return per page (default 50, max 200)
sort | integer | N | asc (default) or desc
search | integer | N | Search by the name field

## Example
### Request

    GET https://hygieia.be/api/v1/space/30/item/list?page_size=2&sort=asc

### Response
``` json
{
    "data": [
        {
            "id": 251,
            "name": "handcontactpunten",
            "created_at": "2019-12-04T12:46:15.000000Z",
            "updated_at": "2019-12-04T12:46:15.000000Z",
            "space": {
                "id": 30,
                "name": "foodtruck",
                "created_at": "2019-12-04T12:34:04.000000Z",
                "updated_at": "2019-12-04T12:34:04.000000Z"
            },
            "frequency": {
                "id": 1,
                "name": "dagelijks",
                "created_at": null,
                "updated_at": "2020-07-28T23:49:20.000000Z"
            },
            "procedure": {
                "id": 8,
                "name": "desinfecteren",
                "description": "Neem het vuil weg en zet het recipiënt in met een oplossing van desinfectant.  Laat minimaal 5 minuten inweken.  Neem de oplossing weg met zuiver water en droog met een zuiver doek of laat aan de lucht drogen.",
                "created_at": "2019-11-06T10:38:32.000000Z",
                "updated_at": "2019-11-06T10:38:32.000000Z"
            },
            "icon": {
                "id": 31,
                "name": "handcontactpunten",
                "image": "/uploads/images/handcontactpunten_1572970942.bmp",
                "type": "item",
                "created_at": "2019-11-05T17:22:22.000000Z",
                "updated_at": "2019-11-05T17:22:22.000000Z"
            }
        },
        {
            "id": 252,
            "name": "keukenmateriaal",
            "created_at": "2019-12-04T12:46:53.000000Z",
            "updated_at": "2019-12-04T12:46:53.000000Z",
            "space": {
                "id": 30,
                "name": "foodtruck",
                "created_at": "2019-12-04T12:34:04.000000Z",
                "updated_at": "2019-12-04T12:34:04.000000Z"
            },
            "frequency": {
                "id": 7,
                "name": "na gebruik",
                "created_at": null,
                "updated_at": null
            },
            "procedure": {
                "id": 9,
                "name": "via vaatwasmachine",
                "description": "Spoel de vuile recipiënten eerst voor onder stromend water.  Plaats alles in een mand en zet deze in de vaatwasmachine.  Als het vaatwasproces klaar is dan haal je de mand uit de vaatwasmachine en laat je deze aan de lucht drogen.  droog eventueel na met een zuivere doek.",
                "created_at": "2019-11-06T10:40:09.000000Z",
                "updated_at": "2019-11-06T10:40:09.000000Z"
            },
            "icon": {
                "id": 40,
                "name": "keukenmateriaal",
                "image": "/uploads/images/keukenmateriaal_1572971162.bmp",
                "type": "item",
                "created_at": "2019-11-05T17:26:02.000000Z",
                "updated_at": "2019-11-05T17:26:02.000000Z"
            }
        }
    ],
    "links": {
        "first": "https://hygieia.be/api/v1/space/30/item/list?page=1",
        "last": "https://hygieia.be/api/v1/space/30/item/list?page=5",
        "prev": null,
        "next": "https://hygieia.be/api/v1/space/30/item/list?page=2"
    },
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 5,
        "path": "https://hygieia.be/api/v1/space/30/item/list",
        "per_page": 2,
        "to": 2,
        "total": 10
    },
    "version": "1.0.0",
    "status": "success",
    "code": 200,
    "valid_as_of": "Tue, 04 Aug 2020 23:06:44"
}
```

[Items]: README.md
[Space]: ../spaces/README.md