<script>
    // Setup currency
    var currency = {!! json_encode(get_application_currency()) !!};
    window.sharedData.company_currency = currency;
    setupPriceInput(window.sharedData.company_currency);

    $(".save_form_button").click(function() {
        var form = $(this).closest('form');
       
        // Remove price mask from values
        var price_inputs = form.find('.price_input');
        price_inputs.each(function (index, elem) {
            var price_input = $(elem);
            price_input.val(price_input.unmask());
        });
        
        // Submit form
        form.submit();
    });
    
</script> 