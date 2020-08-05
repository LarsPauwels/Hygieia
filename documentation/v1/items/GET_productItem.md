# GET All Products By Item

    GET item/{id}/product
    
Returns all the [Products] for a certain [Item]

## Parameters
### URI Parameters
Field | Data Type | Required | Description
--- | --- | --- | ---
id | integer | Y | Unique identifier

## Example
### Request

    GET https://hygieia.be/api/v1/item/45/product

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
            }
        ]
    },
    "version": "1.0.0",
    "status": "success",
    "code": 200,
    "valid_as_of": "Tue, 04 Aug 2020 23:29:05"
}
```

[Item]: README.md
[Products]: ../products/README.md