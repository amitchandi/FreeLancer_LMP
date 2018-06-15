<?php 
session_start();

$products = '';
$w2 = '';
if (isset($_GET['products'])) {
	$products = $_GET['products'] + 1;
	$w2 = $products + 1;
}

include_once('../database/class.database.php');
$database = new Database();

$database->query("SELECT DISTINCT category FROM PricelistT");

$products_item = '<input name="pcount" value="' . $products . '" hidden />';
$products_item .= '<div class="products" class=" text" id="product_' . $products . '"><div>';
$products_item .='<span><label class="description" for="select_' . $products . '">Category</label>';
$products_item .='<select class=" select large" id="select_' . $products . '" name=" category[]">';
foreach ($database->resultset() as $key => $value) {
	$products_item .= '<option value="' . $value['category'] . '">' . $value['category'] . '</option>';
}
$products_item .='</select></span><span><label class="description" for="pname_' . $products . '">Product ' . $products . '</label>';
$products_item .='<input onkeyup="findProduct(' . $products . ')" id="pname_' . $products . '" name="pname[]" class="element text" maxlength="255" size="14" value=""/></span>';
$products_item .= <<<EOT
	</div>
	<div>
	<span>
		<label class="description" for="weight{$products}_{$products}">Weight {$products} </label>
		<input onkeyup="calcWeight({$products})" id="weight{$products}_{$products}" name="weight1[]" class="element text small weights_{$products}" type="text" maxlength="255" value=""/> 
	</span>
	<span>
		<label class="description" for="weight{$w2}_{$products}">Weight {$w2} </label>
		<input onkeyup="calcWeight({$products})" id="weight{$w2}_{$products}" name="weight2[]" class="element text small weights_{$products}" type="text" maxlength="255" value=""/> 
	</span>
	<span>
		<label class="description" for="pweight">Product Weight </label>
		<input id="pweight_{$products}" name="pweight[]" class="element text small" type="text" maxlength="255" value="" readonly /> 
	</span></div></div>
EOT;
echo $products_item;

?>