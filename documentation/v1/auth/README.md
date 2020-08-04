# Auth Object

Field | Data Type | Read Only | Description
--- | --- | --- | --- 
user -> id | integer | Y | Unique identifier
user -> name | string | N | 
user -> email | string | N | 
user -> created_at | timestamp | Y | Shows the date when the account is created
user -> updated_at | timestamp | Y | Shows the date when the account is updated
user -> deleted_at | timestamp | Y | Returns the date when the user is deleted or null when not deleted

token | string | Y | Unique Bearer token needed to login