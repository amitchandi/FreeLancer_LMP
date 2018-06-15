<!DOCTYPE html>
<html>
<head>
<style>
table {
    font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

table td, table th {
    border: 1px solid #ddd;
    padding: 8px;
}

table tr:nth-child(even){background-color: #f2f2f2;}

table tr:hover {background-color: #ddd;}

table th {
    padding-top: 12px;
    padding-bottom: 12px;
    text-align: left;
    background-color: #4CAF50;
    color: white;
}
</style>
</head>
<body>

<?php
include_once('../database/class.database.php');
$database = new Database();

$database->query('SELECT Purchases.CustomerID, PricelistT.Category, Purchases.PDate, Purchases.PNumber, Purchases_PriceList.PurchaseId, Purchases_PriceList.PriceListID, Purchases_PriceList.Price, Purchases_PriceList.PWeight, Purchases_PriceList.PValue, PricelistT.Product, 
Purchases.Total FROM Purchases INNER JOIN (PricelistT INNER JOIN Purchases_PriceList ON PricelistT.[ID] = Purchases_PriceList.[PriceListID]) ON Purchases.[ID] = Purchases_PriceList.[PurchaseId];
');

//print_r($database->resultset());

$table = "<table style='border: 1px solid'>";
$table .="<thead>";
$table .="<tr>";
$table .="<th>CustomerID</th>";
$table .="<th>Category</th>";
$table .="<th>PDate</th>";
$table .="<th>PNumber</th>";
$table .="<th>PurchaseID</th>";
$table .="<th>PriceListID</th>";
$table .="<th>Price</th>";
$table .="<th>PWeight</th>";
$table .="<th>PValue</th>";
$table .="<th>Product</th>";
$table .="<th>Total</th>";
$table .="</tr>";
$table .="</thead><tbody>";
foreach ($database->resultset() as $key => $value) {
	$table .="<tr>";
	
	$table .="<td>" . $value['CustomerID'] . "</td>";
	$table .="<td>" . $value['Category'] . "</td>";
	$table .="<td>" . $value['PDate'] . "</td>";
	$table .="<td>" . $value['PNumber'] . "</td>";
	$table .="<td>" . $value['PurchaseId'] . "</td>";
	$table .="<td>" . $value['PriceListID'] . "</td>";
	$table .="<td>$ " . number_format($value['Price'], 2) . "</td>";
	$table .="<td>" . $value['PWeight'] . "</td>";
	$table .="<td>$ " . number_format($value['PValue'], 2) . "</td>";
	$table .="<td>" . $value['Product'] . "</td>";
	$table .="<td>$ " . number_format($value['Total'], 2) . "</td>";
	
	$table .="</tr>";
}

$table .= "</tbody></table>";

echo $table;

?>

</body>
</html>