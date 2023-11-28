$(() => {
    const $fileRemoveButtons = $('button.file-remove');
    const $filesGroup = $('fieldset#files-group');
    const csrfToken = $('meta[name="csrf-token"]').attr('content');

    const removeFile = async (element) => {
        const target = $(element.currentTarget);
        const li = target.closest('li');
        const idPurchaseRequestFile = li.data("id-purchase-request-file");

        if (!idPurchaseRequestFile) {
            console.error("Atributo id-purchase-request-file está faltando ou não está correto.");
            return;
        }

        try {
            const response = await fetch(`/request/remove-file/${idPurchaseRequestFile}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                }
            });

            if (response.ok) {
                li.remove();
                $filesGroup.find('div.alert-success').fadeIn(500).fadeOut(2500);

                const $spanInfoFiles = $('.span-info-files');
                $spanInfoFiles.text('');
            } else {
                $filesGroup.find('div.alert-danger').fadeIn(500).fadeOut(2500);
            }
        } catch (error) {
            console.error(error);
        }
    }

    $fileRemoveButtons.on('click', function(event) {
        event.preventDefault();

        const title = 'Deseja realmente excluir o anexo ?';
        const message = 'Este anexo será excluído. Essa ação não pode ser desfeita.';

        $.fn.showModalAlert(title, message, () => removeFile(event))
    });
});
