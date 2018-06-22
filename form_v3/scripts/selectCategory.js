$(function() {
	$( "#product_select" ).selectmenu({
	  select: function( event, ui ) {
	  	$.ajax({
	  		data: { category: ui.item.value },
	      	type: 'POST',
	      	url: 'php/ProductName.php',
	      	success: function(result) {
	        	/*initiate the autocomplete function on the "fill_pname" element*/
	        	$( "#fill_pname" ).autocomplete( "destroy" );
	        	$( "#fill_pname" ).autocomplete({
		          	source: JSON.parse(result)
	        	});
	        	$( "#fill_pname" ).autocomplete({
					appendTo: "#pname_auto"
			  	}).autocomplete("widget").addClass("fixed-height");
	      	},
	    });
	  }
	});

	$( "#product_select" ).selectmenu( "option", "width", 200 );
});