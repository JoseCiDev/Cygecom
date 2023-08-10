$(() => {
    const doneTypingInterval = 500;
    let typingTimer;
    let autoCompleteVisible = false;

    $('[name^="purchase_request_products"]').on('input', function () {
        clearTimeout(typingTimer);
        const $autocompleteElement = $(this).closest('.product-row').find('.product-suggestion-autocomplete');
        const category_id = $(this).closest('.product-row').find('select').val();
        const search_term = $(this).val();
        
        if($(this).val().length <= 3 ) {
            return $autocompleteElement.empty().hide();
        }

        typingTimer = setTimeout(function () {
            $.get('/api/products/suggestion', { category_id, search_term },
            function (data) {
                const suggestions = data.response.map(item => item.name);
                $autocompleteElement.empty();

                suggestions.forEach(suggestion => $autocompleteElement.append(`<li>${suggestion}</li>`));

                $autocompleteElement.show();
                autoCompleteVisible = true;
            }.bind(this));
        }.bind(this), doneTypingInterval);
    });

    $('.product-suggestion-autocomplete').on('click', 'li', function () {
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