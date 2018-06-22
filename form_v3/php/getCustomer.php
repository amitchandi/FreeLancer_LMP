<?php

include_once('../database/class.database.php');
$db = new Database();

if (isset($_POST['fname'])) {
	$db->query('SELECT DISTINCT FirstName, LastName, PostCode, Address, CarReg FROM CustomerT WHERE FirstName = :fname');
	$db->bind(':fname', $_POST['fname'], PDO::PARAM_STR);
} else if (isset($_POST['lname'])) {
	$db->query('SELECT DISTINCT FirstName, LastName, PostCode, Address, CarReg FROM CustomerT WHERE LastName = :lname');
	$db->bind(':lname', $_POST['lname'], PDO::PARAM_STR);
} else if (isset($_POST['CarReg'])) {
	$db->query('SELECT DISTINCT FirstName, LastName, PostCode, Address, CarReg FROM CustomerT WHERE CarReg = :CarReg');
	$db->bind(':CarReg', $_POST['CarReg'], PDO::PARAM_STR);
}

$array = array();
foreach ($db->resultset() as $key => $value) {
	$array[$key]['FirstName'] = $value['FirstName'];
	$array[$key]['LastName'] = $value['LastName'];
	$array[$key]['PostCode'] = $value['PostCode'];
	$array[$key]['Address'] = $value['Address'];
	$array[$key]['CarReg'] = $value['CarReg'];
}

if (count($array) == 1) {
	echo json_encode($array);
} else {
	echo true;
}

?>