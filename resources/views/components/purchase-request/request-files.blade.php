<fieldset id="files-group">
    <h4 style="margin-bottom: 20px;"><i class="fa fa-paperclip"></i> Anexos </h4>
    <span class="span-info-files"></span>
    <input type="file" class="form-control" name="arquivos[]" id="files" data-cy="files" multiple>
    <ul class="list-group" style="margin-top:15px">
        @if (isset($files))
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
                        <div class="col-xs-6 text-right">
                            <button type="button" class="btn btn-primary file-remove">
                                <i class='fa fa-trash' style='margin-right:5px'></i>Excluir
                            </button>
                        </div>
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

<script src="{{asset('js/purchase-request/file-upload-validation.js')}}"></script>
<script src="{{ asset('js/service-form/file-remove-button-config.js') }}"></script>
