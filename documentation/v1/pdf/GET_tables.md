# Generate Tables

    GET client/{id}/tabels/{year}
    
Returns a downloadable zip with pdf's for a certain [Client] |yearly|

## Parameters
### URI Parameters
Field | Data Type | Required | Description
--- | --- | --- | ---
id | integer | Y | Unique identifier
year | integer | Y | The year you wish to have a table for

## Example
### Request

    GET https://hygieia.be/api/v1/client/4/tabels/2020

### Response
downloadable zip PDF's
![GET_tables_zip](../images/GET_tables_zip.png)
![GET_tables_pdf](../images/GET_tables_pdf.png)

[Client]: ../clients/README.md