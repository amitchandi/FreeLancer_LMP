<?php
include_once('../database/class.database.php');
$db = new Database();
$db->query('SELECT DISTINCT LastName FROM CustomerT');

$array = array();
foreach ($db->resultset() as $key => $value) {
	$array[$key] = $value['LastName'];
}

echo json_encode($array);
?>