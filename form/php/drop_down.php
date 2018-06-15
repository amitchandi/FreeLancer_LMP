<?php
include_once('class.database.php');
$db = new Database();
$db->query('SELECT DISTINCT category FROM product');

$html = '<select id="select_drop_down" onclick="filterCategory()"><option selected="selected">Category</option>';

foreach ($db->resultset() as $key => $value) {
	$html .= '<option>' . $value['category'] . '</option>';
}
$html .= '</select>';

echo $html;
?>