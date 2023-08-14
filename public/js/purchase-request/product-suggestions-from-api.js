$(() => {
    const doneTypingInterval = 500;
    let typingTimer;
    let autoCompleteVisible = false;

    $(document).on('input', '[name^="purchase_request_products"][name$="[name]"]', function () {
        clearTimeout(typingTimer);
        const $autocompleteElement = $(this).closest('.product-row').find('.product-suggestion-autocomplete');
        const category_id = $(this).closest('.product-row').find('select').val();
        const search_term = $(this).val();
        
        if($(this).val().length <= 3 ) {
            return $autocompleteElement.empty().hide();
        }

        typingTimer = setTimeout(function () {
            $.ajax({
                url: '/api/products/suggestion',
                method: 'GET',
                headers: { 'Authorization': 'Bearer ' + USER_ACCESS_TOKEN },
                data: { category_id, search_term },
                success: function (data) {
                    const suggestions = data.response.map(item => item.name);
                    $autocompleteElement.empty();
            
                    suggestions.forEach(suggestion => $autocompleteElement.append(`<li>${suggestion}</li>`));
            
                    $autocompleteElement.show();
                    autoCompleteVisible = true;
                },
            });
        }.bind(this), doneTypingInterval);
    });

    $(document).on('click', '.product-suggestion-autocomplete li', function () {
        const suggestion = $(this).text();
        $(this).closest('.product-row').find('[name$="[name]"]').val(suggestion);
        $(this).closest('.product-suggestion-autocomplete').hide();
        autoCompleteVisible = false;
    });

     // Evento para capturar cliques fora do autocomplete
    $(document).on('click', function (event) {
        if (!$(event.target).closest('.product-suggestion-autocomplete').length && autoCompleteVisible) {
            $('.product-suggestion-autocomplete').hide();
            autoCompleteVisible = false;
        }
    });
});