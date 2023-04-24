@extends('layouts.app')

@section('content')
<pre>
    {{var_dump($user)}}
</pre>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <h3 class="card-header">Informações do usuário e configurações</h3>
                <div class="card-body">
                    <form method="POST" action="{{ route('userUpdate', ['id'=> $user['id']]) }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Nome') }}</label>
                            <div class="col-md-6"><input id="name" type="text" class="form-control" name="name" value="{{$user['person']['name']}}"></div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('E-mail') }}</label>
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{$user['email']}}" >
                                @error('email') <strong>{{ $message }}</strong>@enderror
                            </div>
                        </div>

                        {{-- <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Senha') }}</label>
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password">
                                @error('password') <strong>{{ $message }}</strong> @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirme senha') }}</label>
                            <div class="col-md-6"><input id="password-confirm" type="password" class="form-control" name="password_confirmation"></div>
                        </div> --}}

                        <hr>

                        <div class="d-flex justify-content-center gap-5 mb-3">
                            <div class="form-check">
                                <label class="form-check-label" for="profile_admin">Administrador</label>
                                <input @if ($user['profile']['profile_name'] === "admin") {{"checked"}}@endif
                                 class="form-check-input" type="radio" name="profile_type" id="profile_admin" value="admin">
                            </div>
                            <div class="form-check">
                                <label class="form-check-label" for="personal">Padrão</label>
                                <input @if ($user['profile']['profile_name'] === "normal") {{"checked"}} @endif
                                class="form-check-input" type="radio" name="profile_type" id="profile_normal" value="normal">
                            </div>
                        </div> 
                        
                        <div class="row mb-3">
                            <label for="approver_user_id" class="col-md-4 col-form-label text-md-end">{{ __('Usuário aprovador') }}</label>
                            <div class="col-md-6">
                                <input id="approver_user_id" type="number" class="form-control" name="approver_user_id" min="0" 
                                @if (isset($user['approver']['email'])) value="{{$user['approver']['email']}}" @endif>
                             </div>
                        </div>    

                        <div class="row mb-3">
                            <label for="approve_limit" class="col-md-4 col-form-label text-md-end">{{ __('Limite de aprovação') }}</label>
                            <div class="col-md-6"><input id="approve_limit" type="number" class="form-control" name="approve_limit" min="1" value="{{$user['approve_limit']}}"></div>
                        </div>    

                        <hr>

                        <div class="row mb-3">
                            <label for="birthdate" class="col-md-4 col-form-label text-md-end">{{ __('Nascimento') }}</label>
                            <div class="col-md-6"><input id="birthdate" type="date" class="form-control" name="birthdate" value="{{$user['person']['birthdate']}}"></div>
                        </div>
                        <div class="row mb-3">
                            <label for="document_number" class="col-md-4 col-form-label text-md-end">{{ __('CPF/CNPJ') }}</label>
                            <div class="col-md-6"><input id="document_number" type="text" class="form-control" name="document_number" value="{{$user['person']['identification']['identification']}}"></div>
                        </div>
                        <div class="row mb-3">
                            <label for="phone" class="col-md-4 col-form-label text-md-end">{{ __('Telefone/Celular') }}</label>
                            <div class="col-md-6">
                                <input id="phone" type="text" class="form-control mb-3" name="phone" value="{{$user['person']['phone']['number']}}">
                                <div class="form-check">
                                    <input  @if ($user['person']['phone']['phone_type'] === "personal") {{"checked"}} @endif
                                     class="form-check-input" type="radio" name="phone_type" id="personal" value="personal" >
                                    <label class="form-check-label" for="personal">
                                        Pessoal
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input @if ($user['person']['phone']['phone_type'] === "commercial") {{"checked"}} @endif
                                    class="form-check-input" type="radio" name="phone_type" id="commercial" value="commercial">
                                    <label class="form-check-label" for="commercial">
                                        Comercial
                                    </label>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="row mb-3">
                            <label for="country" class="col-md-4 col-form-label text-md-end">{{ __('País') }}</label>
                            <div class="col-md-6"><input id="country" type="text" class="form-control" name="country" value="{{$user['person']['address']['country']}}"></div>
                        </div>
                        <div class="row mb-3">
                            <label for="postal_code" class="col-md-4 col-form-label text-md-end">{{ __('CEP') }}</label>
                            <div class="col-md-6"><input id="postal_code" type="text" class="form-control" name="postal_code" value="{{$user['person']['address']['postal_code']}}"></div>
                        </div>
                        <div class="row mb-3">
                            <label for="state" class="col-md-4 col-form-label text-md-end">{{ __('Estado/UF') }}</label>
                            <div class="col-md-6"><input id="state" type="text" class="form-control" name="state" value="{{$user['person']['address']['state']}}"></div>
                        </div>
                        <div class="row mb-3">
                            <label for="city" class="col-md-4 col-form-label text-md-end">{{ __('Cidade') }}</label>
                            <div class="col-md-6"><input id="city" type="text" class="form-control" name="city" value="{{$user['person']['address']['city']}}"></div>
                        </div>
                        <div class="row mb-3">
                            <label for="neighborhood" class="col-md-4 col-form-label text-md-end">{{ __('Bairro') }}</label>
                            <div class="col-md-6"><input id="neighborhood" type="text" class="form-control" name="neighborhood" value="{{$user['person']['address']['neighborhood']}}"></div>
                        </div>
                        <div class="row mb-3">
                            <label for="street" class="col-md-4 col-form-label text-md-end">{{ __('Rua') }}</label>
                            <div class="col-md-6"><input id="street" type="text" class="form-control" name="street" value="{{$user['person']['address']['street']}}"></div>
                        </div>
                        <div class="row mb-3">
                            <label for="street_number" class="col-md-4 col-form-label text-md-end">{{ __('Número') }}</label>
                            <div class="col-md-6"><input id="street_number" type="number" class="form-control" name="street_number" value="{{$user['person']['address']['street_number']}}"></div>
                        </div>
                        <div class="row mb-3">
                            <label for="complement" class="col-md-4 col-form-label text-md-end">{{ __('Complemento') }}</label>
                            <div class="col-md-6"><input id="complement" type="text" class="form-control" name="complement" value="{{$user['person']['address']['complement']}}"></div>
                        </div>
                        <hr>

                            <button type="submit" class="btn btn-primary">Atualizar usuário</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
