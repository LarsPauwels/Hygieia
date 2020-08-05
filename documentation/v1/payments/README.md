# Payment Object

Field | Data Type | Read Only | Description
--- | --- | --- | --- 
id | integer | Y | Unique identifier
name | string | N | The company name
email | string | N | 
address | string | N | The address of the company
logo_path | string | N | The path to your logo
expires_at | timestamp | Y | Shows the date when the payment is due
created_at | timestamp | Y | Shows the date when the account is created
updated_at | timestamp | Y | Shows the date when the account is updated
deleted_at | timestamp | Y | Returns the date when the user is deleted or null when not deleted