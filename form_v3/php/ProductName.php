<?php
include_once('../database/class.database.php');
$db = new Database();

$db->query('SELECT DISTINCT Product FROM PriceListT WHERE PRODUCT IS NOT NULL');

if (isset($_POST['category']) && $_POST['category'] != "") {
	$db->query('SELECT DISTINCT Product FROM PriceListT WHERE PRODUCT IS NOT NULL AND Category = :category');
	$db->bind(':category', $_POST['category'], PDO::PARAM_STR);
}

$array = array();
foreach ($db->resultset() as $key => $value) {
	$array[$key] = $value['Product'];
}

echo json_encode($array);
?>