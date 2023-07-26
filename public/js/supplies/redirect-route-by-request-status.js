$(() => {
    const filterStatusSelect = $('#filterStatus');
    filterStatusSelect.on('change', function () {
        const selectedOption = $(this).find(':selected');
        const href = selectedOption.data('href');
        if (href) {
            window.location.href = href;
        } 
    });
});