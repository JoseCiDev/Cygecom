<input value="{{ $cnpj }}" type="text" name="{{$name}}" id="{{$id}}" data-cy="{{$dataCy}}" placeholder="00.000.000/0000-00" 
class="form-control cpf-cnpj" minLength="18">
<span class="cnpj-span-warning">CNPJ inválido!</span>
<input type="hidden" id="cnpj-validator" value="" required data-rule-required="true">

<script>
    const $identificationDocument = $('.cpf-cnpj');
    $identificationDocument.imask({ mask: '00.000.000/0000-00' });
</script>

<script>
    const validateCNPJ = (cnpj) => {
        cnpj = cnpj.replace(/[^\d]+/g,'');
        
        if (cnpj.length !== 14) return false;
        if (/^(\d)\1+$/.test(cnpj)) return false;
    
        let size = cnpj.length - 2;
        let numbers = cnpj.substring(0, size);
        let digits = cnpj.substring(size);
        let sum = 0;
        let pos = size - 7;
    
        for (let i = size; i >= 1; i--) {
            sum += numbers.charAt(size - i) * pos--;
            if (pos < 2) pos = 9;
        }
    
        let result = sum % 11 < 2 ? 0 : 11 - sum % 11;
        if (result !== parseInt(digits.charAt(0))) return false;
    
        size += 1;
        numbers = cnpj.substring(0, size);
        sum = 0;
        pos = size - 7;
    
        for (let i = size; i >= 1; i--) {
            sum += numbers.charAt(size - i) * pos--;
            if (pos < 2) pos = 9;
        }
    
        result = sum % 11 < 2 ? 0 : 11 - sum % 11;
        if (result !== parseInt(digits.charAt(1))) return false;
    
        return true;
    }

    $(() => {
        const $inputCnpjValidator = $('#cnpj-validator');
        const $cnpjSpanWarning = $('.cnpj-span-warning');
        $('#{{$id}}').on('input', function () {
            const cnpj = $(this).val();
            if (cnpj.length === 18) {
                const isValid = validateCNPJ(cnpj);
                if(!isValid) {
                    $inputCnpjValidator.val('');
                    $cnpjSpanWarning.show();
                } else {
                    $inputCnpjValidator.val(true);
                     $cnpjSpanWarning.hide();
                }
            } 
        });
    });
</script>
    