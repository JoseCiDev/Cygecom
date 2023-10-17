<fieldset id="files-group">
    <h3 style="margin-bottom: 20px;"><i class="fa fa-paperclip"></i> Anexos {{$isSupplies ? 'de Suprimentos' : ''}} </h3>
    <span class="span-info-files"></span>
    <input type="file" class="form-control" name="arquivos[]" id="files" data-cy="files" multiple>
    <ul class="list-group" style="margin-top:15px">
        @if ($files)
            @foreach ($files as $each)
                @php
                    $filenameSearch = explode('/', $each->original_name);
                    $filename = end($filenameSearch);
                @endphp
                <li class="list-group-item" data-id-purchase-request-file="{{ $each->id }}">
                    <div class="row">
                        <div class="col-xs-6">
                            <i class='fa fa-file'></i>
                            <a style='margin-left:5px' href="{{ env('AWS_S3_BASE_URL') . $each->path }}"target="_blank">{{ $filename }}</a>
                        </div>
                        @if(!$isSupplies)
                            <div class="col-xs-6 text-right">
                                <button type="button" class="btn btn-primary file-remove">
                                    <i class='fa fa-trash' style='margin-right:5px'></i>Excluir
                                </button>
                            </div>
                        @endif
                    </div>
                </li>
            @endforeach
        @endif
    </ul>
    <div class="alert alert-success" style="display:none;margin:15px 0px 15px 0px;">
        <i class="fa fa-check"></i> Excluído com sucesso!
    </div>
    <div class="alert alert-danger" style="display:none;margin:15px 0px 15px 0px;">
        <i class="fa fa-close"></i> Não foi possível excluir, por favor tente novamente mais tarde.
    </div>
</fieldset>

@if($isSupplies)
    <button id="supplies-upload-btn" type="button" class="btn btn-primary btn-small btn-draft">
        Salvar anexos
    </button>

    @push('scripts')
        <script type="module">
            $(() => {
                $('#supplies-upload-btn').on('click', function() {
                    const formData = new FormData();
                    formData.append('purchase_request_id', {{$purchaseRequestId}});
                    formData.append('purchaseRequestType', "{{$purchaseRequestType}}");

                    const files = $('#files')[0].files;

                    if(!files.length) {
                        bootbox.alert({
                            title: "Opa, não existe anexos para salvar.",
                            message: `Por favor, verifique novamente o campo de anexos e tente novamente.`,
                        });
                        return;
                    }

                    for (let i = 0; i < files.length; i++) {
                        formData.append('arquivos[]', files[i]);
                    }

                    const csrfToken = $('meta[name="csrf-token"]').attr('content');

                    $.ajax({
                        url: '{{route("api.supplies.files.upload")}}',
                        method: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                        success: function(response) {
                            bootbox.alert({
                                title: "<i class='fa fa-check'></i> Envio de arquivo(s) concluído!",
                                message: `Os anexos adicionados foram salvos com sucesso.`,
                                className: 'bootbox-custom-success',
                                callback: function () {
                                    $('#files').val('');
                                    window.location.reload()
                                }
                            });
                        },
                        error: function(error) {
                            bootbox.alert({
                                title: "<i class='fa fa-check'></i> Envio de arquivo(s) falhou!",
                                message: `Desculpe, não foi possível salvar novos arquivos.`,
                                className: 'bootbox-custom-warning',
                                callback: function () {
                                    $('#files').val('');
                                    window.location.reload()
                                }
                            });
                        }
                    });
                    $('#files').val('');
                })
            });
        </script>
    @endpush
@endif

@push('scripts')
    <script type="module">
        const IS_SUPPLIES_FILES =  {!! json_encode($isSupplies) !!};
    </script>
    <script type="module" src="{{asset('js/purchase-request/file-upload-validation.js')}}"></script>

    @if (!$isSupplies)
        <script type="module" src="{{ asset('/js/service-form/file-remove-button-config.js') }}"></script>
    @endif
@endpush


