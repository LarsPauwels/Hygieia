# Auth Object

Field | Data Type | Read Only | Description
--- | --- | --- | --- 
[user] | object | Y | Returns the `user` object
deleted_at | timestamp | Y | Returns the date when the user is deleted or null when not deleted
token | string | Y | Unique Bearer token needed to login

[user]: ../users/README.md