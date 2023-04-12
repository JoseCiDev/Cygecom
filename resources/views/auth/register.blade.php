@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if (session('person_id'))
                <h5>Pessoa cadastrada com sucesso!</h5>
                <h5>Registre e vincule um usuário a pessoa.</h5>
                <h5>person_Id: {{session('person_id')}}</h5>
            @endif
            <div class="card">
                <div class="card-header">{{ __('Registrar usuário') }}</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        {{-- <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Nome') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div> --}}

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('E-mail') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Senha') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirme senha') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-center gap-5 mb-3">
                            <div class="form-check">
                                <label class="form-check-label" for="profile_admin">Administrador</label>
                                <input class="form-check-input" type="radio" name="profile_type" id="profile_admin" value="admin" checked>
                            </div>
                            <div class="form-check">
                                <label class="form-check-label" for="personal">Padrão</label>
                                <input class="form-check-input" type="radio" name="profile_type" id="profile_normal" value="normal">
                            </div>
                        </div> 
                        
                        <div class="row mb-3">
                            <label for="approver_user_id" class="col-md-4 col-form-label text-md-end">{{ __('Usuário aprovador') }}</label>
                            <div class="col-md-6"><input id="approver_user_id" type="number" class="form-control" name="approver_user_id" min="0"></div>
                        </div>    

                        <div class="row mb-3">
                            <label for="approve_limit" class="col-md-4 col-form-label text-md-end">{{ __('Limite de aprovação') }}</label>
                            <div class="col-md-6"><input id="approve_limit" type="number" class="form-control" name="approve_limit" min="1"></div>
                        </div>    

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Registar') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
