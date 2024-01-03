<span style="display: none" class="loading-icon"><i class="fa fa-spinner fa-spin"></i></span>
<input value="{{ $value }}" type="text" name="{{ $name }}" id="{{ $id }}"
    data-cy="{{ $dataCy }}" placeholder="00.000-000" class="form-control postal-code" data-rule-required="true"
    data-rule-minlength="10">

@push('scripts')
    <script type="module">
        $(() => {
            $('#{{ $id }}').imask({
                mask: '00.000-000'
            })

            const $postalCode = $('#{{ $id }}');
            $postalCode.on('input', function() {
                if ($(this).val().length < 10) {
                    return;
                }
                const $inputFields = $(
                    '#{{ $id }}, #country, #state, #city, #neighborhood, #street, #complement'
                );
                const $loadingIcon = $('.loading-icon');

                $inputFields.prop('disabled', true);
                $loadingIcon.show();

                const postalCode = $postalCode.val().replace(/\D/g, '');
                if (postalCode.length === 8) {
                    const apiUrl = `https://viacep.com.br/ws/${postalCode}/json`;

                    $.ajax({
                        url: apiUrl,
                        method: 'GET',
                        dataType: 'json',
                        xhrFields: {
                            withCredentials: false
                        },
                        success: function(data) {
                            $('#country').val('Brasil');
                            $('#state').val(data.uf);
                            $('#city').val(data.localidade);
                            $('#neighborhood').val(data.bairro);
                            $('#street').val(data.logradouro);
                            $('#complement').val(data.complemento);
                        },
                        error: function(error) {
                            console.error('Erro:', error);
                        },
                        complete: () => {
                            $inputFields.prop('disabled', false);
                            $loadingIcon.hide();
                            $postalCode.valid();
                        }
                    })
                }
            })
        });
    </script>
@endpush
