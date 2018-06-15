<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Order</title>
<link rel="stylesheet" type="text/css" href="../table.css" media="all">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>
<body>
<div id="container">
<div id="invoice_container">
<?php
if (isset($_POST)){
	$pcount = $_POST['pcount'];
	$name = array('fname' => $_POST['fname'], 'lname' => $_POST['lname']);
	$address = $_POST['address'];
	$zip = $_POST['zip'];
	$car_reg = $_POST['car_reg'];
	$category = $_POST['category'];
	$pname = $_POST['pname'];
	$weight1 = $_POST['weight1'];
	$weight2 = $_POST['weight2'];
	$pweight = $_POST['pweight'];
	$grand_total = 0;
	$sign = '$';
} else {
	
}
//initiate date and time
$now = new DateTime(null, new DateTimeZone('Europe/London'));
$date = $now->format('Y-m-d');
$time = $now->format('H:i:s');

// initiate database connection
include_once('../database/class.database.php');
$database = new Database();

//check for customer and insert new ones
$cust_id = '';
$database->query('SELECT CustomerID FROM CustomerT WHERE FirstName = :fname AND LastName = :lname');
$database->bind(':fname', $name['fname'], PDO::PARAM_STR);
$database->bind(':lname', $name['lname'], PDO::PARAM_STR);
if (!empty($database->resultset())) {
	$cust_id = $database->resultset()[0]['CustomerID'];
} else {
	$database->query('INSERT INTO CustomerT(FirstName, LastName, Address, PostCode, CarReg) VALUES(:fname, :lname, :address, :zip, :car_reg)');
	$database->bind(':fname', $name['fname'], PDO::PARAM_STR);
	$database->bind(':lname', $name['lname'], PDO::PARAM_STR);
	$database->bind(':address', $address, PDO::PARAM_STR);
	$database->bind(':zip', $zip, PDO::PARAM_STR);
	$database->bind(':car_reg', $car_reg, PDO::PARAM_STR);
	$database->execute();
	
	$database->query('SELECT TOP 1 CustomerID FROM CustomerT ORDER BY CustomerID DESC');
	$cust_id = $database->resultset()[0]['CustomerID'];
}

// insert into Purchases
$database->query('INSERT INTO Purchases(CustomerID, PDate) VALUES(:cust_id, :pdate)');
$database->bind(':cust_id', $cust_id, PDO::PARAM_INT);
$database->bind(':pdate', $date, PDO::PARAM_STR);
$database->execute();

// get inserted row id
$database->query('SELECT @@IDENTITY from Purchases');
$pur_id = $database->resultset()[0]['Expr1000'];

// get pnumber of inserted row
$database->query('SELECT PNumber from Purchases WHERE ID = :pur_id');
$database->bind(':pur_id', $pur_id, PDO::PARAM_INT);
$pnumber = $database->resultset()[0]['PNumber'];

// get product id, price, and value (price calculation not in use)
for ($i = 0; $i < $pcount; $i++) {
	$database->query('SELECT id, "Price 1" FROM PricelistT WHERE product = :pname');
	$database->bind(':pname', $pname[$i], PDO::PARAM_INT);
	$price = $database->resultset()[0]['Price 1'];
	$plid = $database->resultset()[0]['id'];
	$value = $pweight[$i] * $price;
	$grand_total += $value;
	
	
	// insert into purchases_pricelist
	$database->query('INSERT INTO Purchases_PriceList(PurchaseId, PriceListID, Price, PWeight, PValue) VALUES(:PurchaseID, :PriceListID, :Price, :PWeight, :PValue)');
	$database->bind(':PurchaseID', $pur_id, PDO::PARAM_INT);
	$database->bind(':PriceListID', $plid, PDO::PARAM_INT);
	$database->bind(':Price', $price, PDO::PARAM_INT);
	$database->bind(':PWeight', $pweight[$i], PDO::PARAM_INT);
	$database->bind(':PValue', $value, PDO::PARAM_INT);
	$database->execute();
}

// insert into Purchases total price
$database->query('UPDATE Purchases SET Total = :grand_total WHERE ID = :pur_id');
$database->bind(':grand_total', $grand_total, PDO::PARAM_INT);
$database->bind(':pur_id', $pur_id, PDO::PARAM_INT);
$database->execute();
unset($grand_total);
	
//information and table beginning
$invoice = <<<EOT
<div id="information_container" style="width: 90%; margin-left: auto; margin-right: auto;">
<p style="text-align: right;"><b>Scrap Metal Purchase</b></p>
<p style="text-align: right;"><b>Lloyds Metal Processors Ltd</b></p>
<p style="text-align: center;"><b>Raikes Clough Industrial Estate, Raikes Lane, Bolton BL3 1RP</b></p>
<p style="text-align: center;"><b>Tel:</b> 01204 392221 &nbsp;&nbsp;&nbsp; <b>Fax:</b> 01204 534401</p>
<p style="text-align: left;"><b>Company Reg No.:</b> 8366686</p>
<p style="text-align: left;"><b>VAT Reg No.:</b> 161434235</p>
<p style="text-align: right;"><em><span style="text-decoration: underline;"<b>INVOICE NO. :</b></span></em> {$pnumber}</p>
<div style="width: 100%; display: table;">
<div style="display: table-row; width:150%;">
<div class="cell" style="display: table-cell;">
<p><b>Date:</b> {$date}</p>
</div>
<div class="cell" style="display: table-cell;"><p><b>Time:</b> {$time}</p></div>
<div class="cell" style="display: table-cell;"><p><b>Vehicle No.:</b> {$car_reg}</p></div>
</div>
</div>
<p><b>Name:</b> {$name["fname"]} {$name["lname"]}</p>
<p><b>Address:</b> {$address}</p>
</div>
<div id="table_container" style="text-align: center; width: 90%; margin-left: auto; margin-right: auto;">
<table style="height: 120px; border-collapse: collapse; border-style: solid;" class="minimalistBlack" height="180" cellpadding="5" border="1">
<thead>
<tr style="height: 10px;">
<th style="width: 20%; text-align: center; height: 10px;">
<p><br /></p>
<p>Weight</p>
</th>
<th style="width: 40; text-align: center; height: 10px;">
<p><br /></p>
<p>Description</p>
</th>
<th style="width: 20%; text-align: center; height: 10px;">
<p>Price<br />per kg/per Mt.</p>
</th>
<th style="width: 20%; text-align: center; height: 10px;">
<p><br /></p>
<p>Value</p></th>
</tr>
</thead>
<tbody>
EOT;

// table middle
for ($i = 0; $i < $pcount; $i++) {
	$database->query('SELECT "Price 1" FROM PricelistT WHERE product = :pname');
	$database->bind(':pname', $pname[$i], PDO::PARAM_INT);
	$price = $database->resultset()[0]['Price 1'];
	$value = $pweight[$i] * $price;
	$grand_total += $value;
	$invoice .= '<tr>';
	if ($weight1 >= $weight2) {
		$invoice .= '<td style="width: 20%; height: 22px;">' . $weight1[$i] . 'kg - ' . $weight2[$i] . 'kg = ' . $pweight[$i] . 'kg</td>';
	} else {
		$invoice .= '<td style="width: 20%; height: 22px;">' . $weight2[$i] . 'kg - ' . $weight1[$i] . 'kg = ' . $pweight[$i] . 'kg</td>';
	}
	
	$invoice .= '<td style="width: 40%; height: 22px;">' . $category[$i] . ': ' . $pname[$i] . '</td>';
	$invoice .= '<td style="width: 20%; height: 22px; text-align: right;">$ ' . number_format($price, 2) . '</td>';
	$invoice .= '<td style="width: 20%; height: 22px; text-align: right;">$ ' .  number_format($value, 2) . '</td>';
	$invoice .= '</tr>';
}
$grand_total = number_format($grand_total, 2);
// table ending
$invoice .= <<<EOT
</tbody>
<tfoot>
<tr style="height: 22px;">
<td style="height: 22px;"></td>
<td style="height: 22px;"></td>
<td style="height: 22px;">
<p style="text-align: right;"><strong>Total Paid:</strong>&nbsp;</p>
</td>
<td style="height: 22px; text-align: right;">{$sign} {$grand_total}</td>
</tr>
</tfoot>
</table>
<br />
<p style="text-align: left; width: 70%; margin-left: auto; margin-right: auto;">I certify that the material above is my own property or that I have full authority to sell it to you</p>
<p style="text-align: left; width: 70%; margin-left: auto; margin-right: auto;">Signed _________________________________________________________</p>
</div>
EOT;


echo $invoice;
?>
<br />
<a href="purchases.php" class="button">See Purchases</a>
</div>
</div>
</body>
</html>