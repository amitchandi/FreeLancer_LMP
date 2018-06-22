$(function() {

    $.ajax({
      type: 'POST',
      url: 'php/CarReg.php',
      success: function(result) {
        /*initiate the autocomplete function on the "name_f" element, and pass along the countries array as possible autocomplete values:*/

        $( "#car_reg" ).autocomplete({
          source: JSON.parse(result),
          select: function( event, ui ) {
              $.ajax({
                data: { CarReg: ui.item.value },
                type: 'POST',
                url: 'php/getCustomer.php',
                success: function(cust) {
                    if (cust != 1) {
                      $( "#name_f" ).val(JSON.parse(cust)[0]['FirstName']);
                      $( "#address" ).val(JSON.parse(cust)[0]['Address']);
                      $( "#zip" ).val(JSON.parse(cust)[0]['PostCode']);
                      $( "#name_l" ).val(JSON.parse(cust)[0]['LastName']);
                    }
                },
              });
          }
        });

      },
    });

    $( "#car_reg" ).autocomplete({
      appendTo: "#car_reg_auto"
  });

});