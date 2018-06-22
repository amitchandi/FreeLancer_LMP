<?php
include_once('../database/class.database.php');
$db = new Database();
$db->query('SELECT DISTINCT category FROM PricelistT');

$html = "";
foreach ($db->resultset() as $key => $value) {
	$html .= '<option value="' . $value['category'] . '">' . $value['category'] . '</option>';
}

echo $html;
?>