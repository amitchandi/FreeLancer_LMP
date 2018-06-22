$(function() {

    $.ajax({
      type: 'POST',
      url: 'php/LastName.php',
      success: function(result) {
        /*initiate the autocomplete function on the "name_f" element*/

        $( "#name_l" ).autocomplete({
          source: JSON.parse(result),
          select: function( event, ui ) {
              $.ajax({
                data: { lname: ui.item.value },
                type: 'POST',
                url: 'php/getCustomer.php',
                success: function(cust) {
                    if (cust != 1) {
                      $( "#name_f" ).val(JSON.parse(cust)[0]['FirstName']);
                      $( "#address" ).val(JSON.parse(cust)[0]['Address']);
                      $( "#zip" ).val(JSON.parse(cust)[0]['PostCode']);
                      $( "#car_reg" ).val(JSON.parse(cust)[0]['CarReg']);
                    }
                },
              });
          }
        });

      },
    });

    $( "#name_l" ).autocomplete({
      appendTo: "#lname_auto"
  });

});