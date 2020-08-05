# Product Object

Field | Data Type | Read Only | Description
--- | --- | --- | --- 
id | integer | Y | Unique identifier
name | string | N | The name of the product
quantity | string | N | The amount you can use of this product
information | file | Y | The path to your information pdf
created_at | timestamp | Y | Shows the date when the account is created
updated_at | timestamp | Y | Shows the date when the account is updated
[icon] | object | Y | Returns the `icon` object

[icon]: ../icons/README.md