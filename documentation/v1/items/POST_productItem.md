# Connect Product and Item

    POST item/{id}/product
    
Returns all the [Products], including the newly connected product, for a certain [Item]

## Parameters
### URI Parameters
Field | Data Type | Required | Description
--- | --- | --- | ---
id | integer | Y | Unique identifier

### Body Parameters
Field | Data Type | Required | Description
--- | --- | --- | ---
product_id | integer | Y | The id to a product

## Example
### Request

    POST https://hygieia.be/api/v1/item/45/product

#### Request Body
```json 
{
    "product_id": 12
}
```

### Response
``` json
{
    "data": {
        "id": 45,
        "name": "tafels",
        "created_at": "2019-12-02T13:24:07.000000Z",
        "updated_at": "2019-12-02T13:24:07.000000Z",
        "products": [
            {
                "id": 7,
                "name": "ecover zero afwasmiddel",
                "quantity": "volgens bevuilingsgraad",
                "icon": {
                    "id": 109,
                    "name": "ecover zero afwasmiddel",
                    "image": "/uploads/images/ecover-zero-afwasmiddel_1575289149.jfif",
                    "type": "product",
                    "created_at": "2019-12-02T13:19:09.000000Z",
                    "updated_at": "2019-12-02T13:19:09.000000Z"
                },
                "created_at": "2019-12-02T13:31:32.000000Z",
                "updated_at": "2019-12-02T13:31:32.000000Z"
            },
            {
                "id": 4,
                "name": "Lamox",
                "quantity": "10ml op 1liter water",
                "icon": null,
                "created_at": "2019-11-07T13:12:10.000000Z",
                "updated_at": "2019-11-07T13:12:10.000000Z"
            },
            {
                "id": 12,
                "name": "DRD micro fast desinfectant",
                "quantity": "8ml voor 1l water \r\n5 minuten inweektijd",
                "icon": {
                    "id": 113,
                    "name": "DRD micro fast desinfectant",
                    "image": "/uploads/images/drd-micro-fast-desinfectant_1575367406.png",
                    "type": "product",
                    "created_at": "2019-12-03T11:03:26.000000Z",
                    "updated_at": "2019-12-03T11:03:26.000000Z"
                },
                "created_at": "2019-12-03T11:08:07.000000Z",
                "updated_at": "2019-12-03T11:08:07.000000Z"
            }
        ]
    },
    "version": "1.0.0",
    "status": "success",
    "code": 200,
    "valid_as_of": "Tue, 04 Aug 2020 23:31:03"
}
```

[Item]: README.md
[Products]: ../products/README.md