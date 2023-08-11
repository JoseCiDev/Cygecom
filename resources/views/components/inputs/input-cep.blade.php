<span style="display: none" class="loading-icon"><i class="fa fa-spinner fa-spin"></i></span>
<input value="{{$value}}" type="text" name="{{$name}}" id="{{$id}}" data-cy="{{$dataCy}}" placeholder="00.000-000" class="form-control postal-code"
    data-rule-required="true" data-rule-minlength="10">

<script>
    $(() => $('#{{$id}}').imask({ mask: '00.000-000' }));
</script>

<script>
    $(() => {
        const $postalCode = $('#{{$id}}');
        $postalCode.on('input', function() {
            if ($(this).val().length < 10) {
                return;
            }
            const $inputFields = $('#{{$id}}, #country, #state, #city, #neighborhood, #street, #complement');
            const $loadingIcon = $('.loading-icon');

            $inputFields.prop('disabled', true);
            $loadingIcon.show();

            const postalCode = $postalCode.val().replace(/\D/g, '');
                if (postalCode.length === 8) {
                    const apiUrl = `https://viacep.com.br/ws/${postalCode}/json`;

                    $.getJSON(apiUrl, function(data) {
                        if (data.erro) {
                            bootbox.alert("Endereço não encontrado para esse CEP.");
                            return;
                        }

                        $('#country').val('Brasil');
                        $('#state').val(data.uf);
                        $('#city').val(data.localidade);
                        $('#neighborhood').val(data.bairro);
                        $('#street').val(data.logradouro);
                        $('#complement').val(data.complemento);
                    }).done(() => {
                        $inputFields.prop('disabled', false);
                        $loadingIcon.hide();
                        $postalCode.valid();
                    })
                }
        })
    });
</script>