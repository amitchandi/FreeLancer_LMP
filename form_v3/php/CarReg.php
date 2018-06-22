<?php
include_once('../database/class.database.php');
$db = new Database();
$db->query('SELECT DISTINCT CarReg FROM CustomerT');

$array = array();
foreach ($db->resultset() as $key => $value) {
	$array[$key] = $value['CarReg'];
}

echo json_encode($array);
?>