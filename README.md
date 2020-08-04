# Food App Rest API

## Overview
This API is a multi-channel communications platform that allows the sending, receiving and automating of conversations between a Business and a Customer. Zingle is typically interacted with by Businesses via a web browser to manage these conversations with their customers. The Zingle API provides functionality to developers to act on behalf of either the Business or the Customer. The Zingle iOS SDK provides mobile application developers an easy-to-use layer on top of the Zingle API.

## Tutorial
We provide a [Postman](https://www.getpostman.com/) collection with a set of requests that introduce the basic concepts of the API.  You will need an existing Zingle account with API access to run this tutorial. The Postman collection and more information are available [here](https://github.com/Zingle/rest-api/tree/master/.postman_tutorial).

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
        "first": "http://hygieia/api/v1/client/list?page=1",
        "last": "http://hygieia/api/v1/client/list?page=57",
        "prev": null,
        "next": "http://hygieia/api/v1/client/list?page=2"
    },
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 57,
        "path": "http://hygieia/api/v1/client/list",
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
For a description of the available resources see the [Resource Overview](/documentation/v1/overview.md) or the [Online Documentation](http://hygieia.be/api/documentation).

### Authentication
- **[<code>POST</code> Login](/documentation/v1/accounts/POST_login.md)**
- **[<code>POST</code> Register](/documentation/v1/accounts/POST_register.md)**
- **[<code>GET</code> Logout](/documentation/v1/accounts/GET_logout.md)**
- **[<code>GET</code> All Users](/documentation/v1/accounts/GET_users.md)**
- **[<code>GET</code> Get User By Id](/documentation/v1/accounts/GET_userId.md)**
- **[<code>PUT</code> Update User By Id](/documentation/v1/accounts/PUT_userId.md)**
- **[<code>DELETE</code> Delete User By Id](/documentation/v1/accounts/DELETE_userId.md)**

### Users

### Clients
- **[<code>GET</code> Login](/documentation/v1/admins/GET_admins.md)**
- **[<code>GET</code> Register](/documentation/v1/admins/GET_adminId.md)**
- **[<code>DELETE</code> Logout](/documentation/v1/admins/DELETE_adminId.md)**

#### Spaces
- **[<code>GET</code> Login](/documentation/v1/companies/POST_login.md)**
- **[<code>GET</code> Register](/documentation/v1/companies/POST_register.md)**
- **[<code>DELETE</code> Logout](/documentation/v1/companies/GET_logout.md)**

#### Payments
- **[<code>GET</code> Login](/documentation/v1/employees/POST_login.md)**
- **[<code>GET</code> Register](/documentation/v1/employees/POST_register.md)**
- **[<code>DELETE</code> Logout](/documentation/v1/employees/GET_logout.md)**

#### PDF
- **[<code>GET</code> Login](/documentation/v1/suppliers/POST_login.md)**
- **[<code>GET</code> Register](/documentation/v1/suppliers/POST_register.md)**
- **[<code>DELETE</code> Logout](/documentation/v1/suppliers/GET_logout.md)**

### Products
- **[<code>GET</code> Login](/documentation/v1/orders/POST_login.md)**
- **[<code>POST</code> Register](/documentation/v1/orders/POST_register.md)**
- **[<code>PUT</code> Login](/documentation/v1/orders/POST_login.md)**
- **[<code>GET</code> Register](/documentation/v1/orders/POST_register.md)**
- **[<code>DELETE</code> Logout](/documentation/v1/orders/GET_logout.md)**
- **[<code>GET</code> Login](/documentation/v1/orders/POST_login.md)**

### Frequencies

### Icons

### Producers