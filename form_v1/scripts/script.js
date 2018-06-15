function addProduct() {
	var products = document.getElementsByClassName('products');
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("products_div").insertAdjacentHTML("beforeend",this.responseText);
		}
	};

	xmlhttp.open("GET", "php/getProduct.php?products=" + products.length, true);
	xmlhttp.send();
	/*
	var xmlhttp1 = new XMLHttpRequest();
	xmlhttp1.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("products_calc_div").insertAdjacentHTML("beforeend",this.responseText);
		}
	};

	xmlhttp1.open("GET", "php/getProductCalc.php", true);
	xmlhttp1.send();*/
};

addProduct();

function getProducts(category) {
	var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("products").innerHTML = this.responseText;
            }
        };
    if (category.length == "") {
        xmlhttp.open("GET", "php/getProducts.php", true);
        xmlhttp.send();
    } else {
        xmlhttp.open("GET", "php/getProducts.php?category=" + category, true);
        xmlhttp.send();
    }
};
function calcWeight(pnum) {
	var weights = document.getElementsByClassName('weights_' + pnum);
	if (weights[0].value != "" && weights[1].value != "") {
		document.getElementById('pweight_' + pnum).value = Math.abs(weights[0].value - weights[1].value);
	}
};

function findProduct(pnum) {
	var category = document.getElementById('select_' + pnum);
	
}