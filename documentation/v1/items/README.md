# Item Object

Field | Data Type | Read Only | Description
--- | --- | --- | --- 
id | integer | Y | Unique identifier
name | string | N | The name of the item
created_at | timestamp | Y | Shows the date when the account is created
updated_at | timestamp | Y | Shows the date when the account is updated
[space] | object | Y | Returns the `space` object
[frequency] | object | Y | Returns the `frequency` object
[procedure] | object | Y | Returns the `procedure` object
[icon] | object | Y | Returns the `icon` object

[space]: ../spaces/README.md
[frequency]: ../frequencies/README.md
[procedure]: ../procedures/README.md
[icon]: ../icons/README.md