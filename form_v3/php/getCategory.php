<?php
include_once('../database/class.database.php');
$db = new Database();

$db->query('SELECT DISTINCT Category FROM PriceListT WHERE PRODUCT = :Product');
$db->bind(':Product', $_POST['product'], PDO::PARAM_STR);

$array = array();
foreach ($db->resultset() as $key => $value) {
	$array[$key] = $value['Category'];
}

echo json_encode($array);
?>