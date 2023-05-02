{{-- {{dd($users[0])}} --}}
<x-app>
    <x-slot name="title">
        <h1>E-mail</h1>
    </x-slot>
    
    <div class="row">
        <div class="col-sm-12">
            <div class="box box-bordered">
                <div class="box-title"><h3><i class="fa fa-th-list"></i>Enviar e-mail:</h3></div>
                <div class="box-content nopadding">
                    <form  method="POST" action="{{route('email')}}" class='form-horizontal form-striped'>
                        @csrf
                        <div class="form-group">
                            <label for="textfield" class="control-label col-sm-2">Destinatário(s):</label>
                            <div class="col-sm-10">
                                <select name="recipients[]" id="recipients" multiple="multiple" class="chosen-select form-control" data-placeholder="Selecione um ou mais e-mails">
                                    @foreach ($users as $user)
                                        <option value="{{$user['email']}}">{{$user['email']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="subject" class="control-label col-sm-2">Assunto:</label>
                            <div class="col-sm-10">
                                <input type="text" name="subject" id="subject" placeholder="Assunto do e-mail" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="textarea" class="control-label col-sm-2">Mensagem:</label>
                            <div class="col-sm-10">
                                <textarea name="body" id="body" rows="5" class="form-control" placeholder="Digite sua mensagem..."></textarea>
                            </div>
                        </div>
                        <div class="form-actions col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary">Enviar</button>
                            <a href="{{ url()->previous() }}" class="btn">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app>
