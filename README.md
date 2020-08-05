[![version](https://img.shields.io/badge/Version-v1.0-green)]

# Hygieia Rest API

## Overview
This API is a multi-channel communications platform that makes the automating of cleaning so much easier for a business. In this version the clients can have limited access in the app. To print their own schedules, but also to manage their spaces, items, .... This makes the communication between Hygieia and their clients more efficient.  

### Support
For API support, please email lars.pauwels@telenet.be.

## Authentication
Access to the API is granted by providing your Bearer authentication token. This token is given when login in with you email and password.

```no-highlight
GET https://hygieia.be/api/v1/login

{
    "data": {
        "user": {
            "id": 26,
            "name": "Jhon Doe",
            "email": "Jhon@doe.be",
            "created_at": "2020-08-04T19:49:51.000000Z",
            "updated_at": "2020-08-04T20:10:48.000000Z",
            "deleted_at": null
        },
        "token": "..."
    },
    "version": "1.0.0",
    "status": "success",
    "code": 200,
    "valid_as_of": "Tue, 04 Aug 2020 20:10:58"
}
```

## API Versioning
The first part of the URI path specifies the API version you wish to access in the format `v{version_number}`. 

For example, version 1 of the API (most current) is accessible via:

```no-highlight
https://hygieia.be/api/v1
```

## HTTP requests
All API requests are made by sending a secure HTTPS request using one of the following methods, depending on the action being taken:

* `POST` Create a resource
* `PUT` Update a resource
* `GET` Get a resource or list of resources
* `DELETE` Delete a resource

For PUT and POST requests the body of your request may include a JSON payload, and the URI being requested may include a query string specifying additional filters or commands, all of which are outlined in the following sections.

## HTTP Responses
Each response will include a `status` object, (if successful) a `data` result (`data` will be an object for single-record queries and an array for list queries) also the `version` of the api and the `valid_as_of` with the date of when the request was made. The `code` object contains an HTTP `status_code`, or `error_code` (if an error occurred - see [Error Codes]). The `data` contains the result of a successful request.  For example:

```no-highlight
{
    "data": {
        ...
    },
    "links": {
        "first": "https://hygieia.be/api/v1/client/list?page=1",
        "last": "https://hygieia.be/api/v1/client/list?page=57",
        "prev": null,
        "next": "https://hygieia.be/api/v1/client/list?page=2"
    },
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 57,
        "path": "https://hygieia.be/api/v1/client/list",
        "per_page": 1,
        "to": 1,
        "total": 57
    },
    "version": "1.0.0",
    "status": "success",
    "code": 200,
    "valid_as_of": "Tue, 04 Aug 2020 20:16:12"
}
```

## HTTP Response Codes
Each response will be returned with one of the following HTTP status codes:

* `200` `OK` The request was successful
* `400` `Bad Request` There was a problem with the request (security, malformed, data validation, etc.)
* `401` `Unauthorized` The supplied API credentials are invalid
* `403` `Forbidden` The credentials provided do not have permission to access the requested resource
* `404` `Not found` An attempt was made to access a resource that does not exist in the API
* `405` `Method not allowed` The resource being accessed doesn't support the method specified (GET, POST, etc.).
* `500` `Server Error` An error on the server occurred

## Request Modifiers
Request modifiers may be included in the request URI query string. The following modifiers are available throughout the API. Other resource-specific modifiers are covered under the specific resource documentation sections.

* `page` The page number in the result set to return (default 1)
* `page_size` The number of records to return per page (default 50, max 200)
* `sort` asc (default) or desc
* `search` Search by the name field

## Resources
For a description of the available resources see the [Resource Overview](/documentation/v1/README.md) or the [Online Documentation](https://hygieia.be/api/documentation).

### Authentication
- **[<code>POST</code> Login](/documentation/v1/auth/POST_login.md)**
- **[<code>GET</code> Logout](/documentation/v1/auth/GET_logout.md)**
- **[<code>PUT</code> Change Password](/documentation/v1/auth/PUT_change.md)**
- **[<code>PUT</code> Forgot Password](/documentation/v1/auth/PUT_forgot.md)**

### Users
- **[<code>GET</code> All Users](/documentation/v1/users/GET_users.md)**
- **[<code>GET</code> All Clients By User](/documentation/v1/users/GET_clients.md)**
- **[<code>GET</code> All Products By User](/documentation/v1/users/GET_products.md)**

### Clients
- **[<code>GET</code> All Clients](/documentation/v1/clients/GET_clients.md)**
- **[<code>GET</code> Client By Id](/documentation/v1/clients/GET_clientId.md)**
- **[<code>POST</code> Create Client](/documentation/v1/clients/POST_client.md)**
- **[<code>PUT</code> Update Client By Id](/documentation/v1/clients/PUT_clientId.md)**
- **[<code>DELETE</code> Delete Client By Id](/documentation/v1/clients/DELETE_clientId.md)**

### Spaces
- **[<code>GET</code> All Spaces By Client](/documentation/v1/spaces/GET_spaces.md)**
- **[<code>GET</code> Space By Id](/documentation/v1/spaces/GET_spaceId.md)**
- **[<code>POST</code> Create Space By Client](/documentation/v1/spaces/POST_space.md)**
- **[<code>PUT</code> Update Space By Id](/documentation/v1/spaces/PUT_spaceId.md)**
- **[<code>DELETE</code> Delete Space By Id](/documentation/v1/spaces/PUT_spaceId.md)**

### Items
- **[<code>GET</code> All Items By Space](/documentation/v1/items/GET_items.md)**
- **[<code>GET</code> Item By Id](/documentation/v1/items/GET_itemId.md)**
- **[<code>POST</code> Create Item By Space](/documentation/v1/items/POST_item.md)**
- **[<code>PUT</code> Update Item By Id](/documentation/v1/items/PUT_itemId.md)**
- **[<code>DELETE</code> Delete Item By Id](/documentation/v1/items/PUT_itemId.md)**
- **[<code>GET</code> All Products By Item](/documentation/v1/items/GET_productItem.md)**
- **[<code>POST</code> Connect Product and Item](/documentation/v1/items/POST_productItem.md)**
- **[<code>DELETE</code> Detach Product and Item](/documentation/v1/items/DELETE_productItem.md)**

### Payments
- **[<code>PUT</code> Update Client Payed](/documentation/v1/payments/PUT_payed.md)**
- **[<code>PUT</code> Update Client Expired](/documentation/v1/payments/PUT_expired.md)**

### PDF
- **[<code>GET</code> Generate PDF](/documentation/v1/pdf/GET_pdf.md)**
- **[<code>GET</code> Generate Table](/documentation/v1/pdf/GET_table.md)**
- **[<code>GET</code> Generate Tables](/documentation/v1/pdf/GET_tables.md)**

### Products
- **[<code>GET</code> All Products](/documentation/v1/products/GET_products.md)**
- **[<code>GET</code> Product By Id](/documentation/v1/products/GET_productId.md)**
- **[<code>POST</code> Create Product](/documentation/v1/products/POST_product.md)**
- **[<code>PUT</code> Update Product By Id](/documentation/v1/products/PUT_productId.md)**
- **[<code>DELETE</code> Delete Product By Id](/documentation/v1/products/PUT_productId.md)**

### Frequencies
- **[<code>GET</code> All Frequencies](/documentation/v1/frequencies/GET_frequencies.md)**
- **[<code>GET</code> Frequency By Id](/documentation/v1/frequencies/GET_frequencyId.md)**
- **[<code>POST</code> Create Frequency](/documentation/v1/frequencies/POST_frequency.md)**
- **[<code>PUT</code> Update Frequency By Id](/documentation/v1/frequencies/PUT_frequencyId.md)**
- **[<code>DELETE</code> Delete Frequency By Id](/documentation/v1/frequencies/PUT_frequencyId.md)**

### Icons
- **[<code>GET</code> All Icons](/documentation/v1/icons/GET_icons.md)**
- **[<code>GET</code> Icon By Id](/documentation/v1/icons/GET_iconId.md)**
- **[<code>POST</code> Create Icon](/documentation/v1/icons/POST_icon.md)**
- **[<code>PUT</code> Update Icon By Id](/documentation/v1/icons/PUT_iconId.md)**
- **[<code>DELETE</code> Delete Icon By Id](/documentation/v1/icons/PUT_iconId.md)**

### Producers
- **[<code>GET</code> All Producers](/documentation/v1/producers/GET_producers.md)**
- **[<code>GET</code> Producer By Id](/documentation/v1/producers/GET_producerId.md)**
- **[<code>POST</code> Create Producer](/documentation/v1/producers/POST_producer.md)**
- **[<code>PUT</code> Update Producer By Id](/documentation/v1/producers/PUT_producerId.md)**
- **[<code>DELETE</code> Delete Producer By Id](/documentation/v1/producers/PUT_producerId.md)**