# Auth Object

Field | Data Type | Read Only | Description
--- | --- | --- | --- 
id | integer | Y | Unique identifier
name | string | N | The company name
address | string | N | The address of the company
email | string | N | 
logo_path | string | N | The path to your logo
created_at | timestamp | Y | Shows the date when the account is created
updated_at | timestamp | Y | Shows the date when the account is updated
[spaces] | object | Y | Returns a collection of `space` objects

[spaces]: spaces/README.md