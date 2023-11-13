$(() => {
    const $filesToUpload = $('#files');
    const $spanInfoFiles = $('.span-info-files');

    const maxFilesQtd = 20;
    const maxFileSizeMB = 40;

    function getFilesQtdFillable (input = $filesToUpload[0]) {;
        const filesQtd = getFilesQtd(input);
        const $filesUploaded = $('.list-group-item')
        const qtdSum = maxFilesQtd - filesQtd;
        const qtdFillable = qtdSum >= 0 ? qtdSum : maxFilesQtd - $filesUploaded.length;
        return qtdFillable;
    }

    function getFilesQtd(input) {
        const $filesUploaded = $('.list-group-item');

        const filesToUploadQtd = input.files.length
        const filesUploadedQtd = $filesUploaded.length;
        const filesQtd = filesToUploadQtd + filesUploadedQtd;

        return filesQtd;
    }

     function isLimitOverflow (input) {
        const filesQtd = getFilesQtd(input);
        const result = filesQtd > maxFilesQtd;
        return result;
    }

    function validateFilesToUpload(event) {
        const input = event.target;

        let totalFileSize = 0;
        const files = input?.files;

        if(!files) {
            return;
        }

        for (const file of input.files) {
            totalFileSize += file.size;
        }

        const totalFileSizeMB = totalFileSize / (1024 * 1024);
        let qtdFillable = getFilesQtdFillable(input);

        let infoFilesMessage = `Você já anexou ${maxFilesQtd - qtdFillable} arquivo(s). Ainda é possível adicionar mais ${qtdFillable} anexo(s).`;
        let infoFilesMessageLimit = `Você atingiu o limite máximo de ${maxFilesQtd} anexos.`;

        if (isLimitOverflow(input)) {
            const title = "Limite de anexos excedido!";
            const message = infoFilesMessageLimit + (!IS_SUPPLIES_FILES ? " Por favor, tente selecionar menos arquivos ou remover alguns já enviados para adicionar novos anexos." : ' Não é possível enviar mais arquivos.');

            $.fn.showModalAlert(title, message);

            $filesToUpload.val('');
        }

        if (totalFileSizeMB > maxFileSizeMB) {
            const title = "Tamanho máximo de arquivo excedido!";
            const message = `O tamanho total dos arquivos selecionados não pode exceder ${maxFileSizeMB} MB.`;

            $.fn.showModalAlert(title, message, function() {
                $filesToUpload.val('');
                validateFilesToUpload({ target: $filesToUpload[0] });
                return;
            });
        }

        $spanInfoFiles.text(qtdFillable ? infoFilesMessage : infoFilesMessageLimit);
    }

    $(document).on('change', $filesToUpload.selector, validateFilesToUpload);
    validateFilesToUpload({ target: $filesToUpload[0] });
});
