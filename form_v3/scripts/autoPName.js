$(function() {

    $.ajax({
      type: 'POST',
      url: 'php/ProductName.php',
      success: function(result) {
        /*initiate the autocomplete function on the "fill_pname" element*/

        $( "#fill_pname" ).autocomplete({
          source: JSON.parse(result),
          select: function( event, ui ) {
              
              $.ajax({
                data: { product: ui.item.value },
                type: 'POST',
                url: 'php/getCategory.php',
                success: function(result) {
                    $( "#product_select" ).val(JSON.parse(result)[0]);
                    $( "#product_select" ).selectmenu("refresh");
                },
              });
          }
        });

      },
    });

    $( "#fill_pname" ).autocomplete({
      appendTo: "#pname_auto"
  }).autocomplete("widget").addClass("fixed-height");

});