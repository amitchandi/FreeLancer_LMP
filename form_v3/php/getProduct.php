<?php 
session_start();

$products = '';
$w2 = '';
if (isset($_GET)) {
	$products = $_GET['products'] + 1;
	$w2_counter = $products + 1;
	$info = json_decode($_GET['info']);
	$pselect = $info[0];
	$pname = $info[1];
	$w1 = $info[2];
	$w2 = $info[3];
	$pw = $info[4];
	
}

include_once('../database/class.database.php');
$database = new Database();

$products_item = '<tr class="products" id="pr' . $products . '"><input id="pcount_' . $products . '" name="pcount" value="' . $products . '" hidden />';

$products_item .='<td><span><label class="description" for="category_' . $products . '">Category</label>';
$products_item .='<input class=" element text small category" id="category_' . $products . '" name="category[]" value="' . $pselect . '" readonly style="border: none;background: transparent; color: #000;" />';
$products_item .='</span></td><td><span><label class="description" for="pname_' . $products . '">Product ' . $products . '</label>';
$products_item .='<input onkeyup="findProduct(' . $products . ')" id="pname_' . $products . '" name="pname[]" class="element text pname" maxlength="255" size="14" value="' . $pname . '" readonly style="border: none;background: transparent; color: #000;" /></span></td>';
$products_item .= <<<EOT
	<td><span>
		<label class="description" id="label{$products}_{$products}" for="weight{$products}_{$products}">Weight {$products} </label>
		<input onkeyup="calcWeight({$products})" id="weight{$products}_{$products}" name="weight1[]" class="element text small weights_before ptable" type="text" maxlength="255" value="{$w1}" readonly style="border: none;background: transparent; color: #000;" /> 
	</span>
	<span>
		<label class="description" id="label{$w2_counter}_{$products}" for="weight{$w2_counter}_{$products}">Weight {$w2_counter} </label>
		<input onkeyup="calcWeight({$products})" id="weight{$w2_counter}_{$products}" name="weight2[]" class="element text small weights_after ptable" type="text" maxlength="255" value="{$w2}" readonly style="border: none;background: transparent; color: #000;" /> 
	</span></td>
	<td><span>
		<label class="description" for="pweight_{$products}">Product Weight </label>
		<input id="pweight_{$products}" name="pweight[]" class="element text small pweight" type="text" maxlength="255" value="{$pw}" readonly style="border: none;background: transparent; color: #000;"/>
	</span></td>
	<td><input type="button" onclick="delRow({$products})" value="X" /></td>
	</tr>
EOT;
echo $products_item;
?>