$(function() {

    $.ajax({
      type: 'POST',
      url: 'php/FirstName.php',
      success: function(result) {
        /*initiate the autocomplete function on the "name_f" element*/
        $( "#name_f" ).autocomplete({
          source: JSON.parse(result),
          select: function( event, ui ) {
              $.ajax({
                data: { fname: ui.item.value },
                type: 'POST',
                url: 'php/getCustomer.php',
                success: function(cust) {
                      if (cust != 1) {
                        $( "#name_l" ).val(JSON.parse(cust)[0]['LastName']);
                        $( "#address" ).val(JSON.parse(cust)[0]['Address']);
                        $( "#zip" ).val(JSON.parse(cust)[0]['PostCode']);
                        $( "#car_reg" ).val(JSON.parse(cust)[0]['CarReg']);
                      }
                        
                    // $( "#product_select" ).val(JSON.parse(result)[0]);
                    // $( "#product_select" ).selectmenu("refresh");
                },
              });
          }
        });

      },
    });

    $( "#name_f" ).autocomplete({
      appendTo: "#fname_auto"
  });

});