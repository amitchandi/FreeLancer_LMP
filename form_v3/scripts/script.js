function addProduct() {
	
	var products = document.getElementsByClassName('products');
	var pdiv = document.getElementById('products_div');
	
	var pselect = document.getElementById('product_select');
	var pname = document.getElementById('fill_pname');
	var w1 = document.getElementById('fill_weight1');
	var w2 = document.getElementById('fill_weight2');
	var pw = document.getElementById('fill_pweight');
	
	var p_info = [pselect.value, pname.value, w1.value, w2.value, pw.value];
	
	pselect.value = "";
	pname.value = "";
	w1.value = "";
	w2.value = "";
	pw.value = "";
	
	var xmlhttp = new XMLHttpRequest();
	
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("table_body").insertAdjacentHTML("beforeend",this.responseText);
		}
	};

	xmlhttp.open("GET", "php/getProduct.php?products=" + products.length + "&info=" + JSON.stringify(p_info), true);
	xmlhttp.send();
	if (pdiv.style.display == 'none') {
		pdiv.style.display = 'block';
	}
};

function calcWeight(pnum) {
	
	var weights = document.getElementsByClassName('fill_weights');
	if (weights[0].value != "" && weights[1].value != "") {
		document.getElementById('fill_pweight').value = Math.abs(weights[0].value - weights[1].value);
	}
};

function getCategories() {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById('product_select').insertAdjacentHTML("afterbegin",this.responseText);
		}
	};

	xmlhttp.open("GET", "php/drop_down.php", true);
	xmlhttp.send();
};

getCategories();

function findProduct(pnum) {
	//var category = document.getElementById('select_' + pnum);
	
};

function delRow(rowNum) {

	var row = document.getElementById('pr' + rowNum);
	row.parentNode.removeChild(row);

	var pcount = document.getElementById('pcount_' + rowNum);
	pcount.parentNode.removeChild(pcount);

	var rows = $('tr.products');

	var categories = [];
	var pname = document.getElementsByClassName('pname');
	var w1 = document.getElementsByClassName('weights_before');
	var w2 = document.getElementsByClassName('weights_after');
	var pw = document.getElementsByClassName('pweight');

	$.each(rows, function(key,valueObj){
			console.log(valueObj);
			//categories.push();
			var x = valueObj;
			x.parentNode.removeChild(x);
	});


	for (var i = 1; i <= rows.length; i++) {

		// console.log(categories[i]);
		//var p_info = [categories[i - 1].value, pname.value, w1.value, w2.value, pw.value];
	}

	if (rows.length == 0) {
		document.getElementById('products_div').style.display = 'none';
	}
};