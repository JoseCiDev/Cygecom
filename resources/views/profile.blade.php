@extends('layouts.app')

@section('content')
<div>
    <div class="container">
        <h1>Configurações de perfil</h1>
        <div class="col-md-4">
                <h4>Seus dados:</h4>
                <p>Nome: {{auth()->user()->person->name}}</p>
                <p>Nascimento: {{auth()->user()->person->birthdate}}</p>
                <p>E-mail: {{auth()->user()->email}}</p>
                <p>Perfil: {{auth()->user()->profile->profile_name}}</p>
                @if (auth()->user()->profile->profile_name === 'admin')
                    <p>User ID: {{auth()->user()->id}}</p>
                    <p>Usuário aprovador ID: {{auth()->user()->approver_user_id}}</p>
                    <p>Limite de aprovação: {{auth()->user()->approve_limit}}</p>
                    <p>Criado em: {{auth()->user()->created_at}}</p>
                    <p>Usuário atualizado em: {{auth()->user()->updated_at}}</p>
                    <p>Pessoa atualizada em: {{auth()->user()->person->updated_at}}</p>
                @endif
        </div>
        <div class="col-md-4">
                <h4>Seu endereço</h4>
                <p>País: {{auth()->user()->person->address->country}}</p>
                <p>Rua: {{auth()->user()->person->address->street}}</p>
                <p>Número da rua: {{auth()->user()->person->address->street_number}}</p>
                <p>Bairro: {{auth()->user()->person->address->neighborhood}}</p>
                <p>Cidade: {{auth()->user()->person->address->city}}</p>
                <p>Estado/UF: {{auth()->user()->person->address->state}}</p>
                <p>Completo: {{auth()->user()->person->address->complement}}</p>
                @if (auth()->user()->profile->profile_name === 'admin')
                    <p>Supplier_id: {{auth()->user()->person->address->supplier_id}}</p>
                    <p>Person_id: {{auth()->user()->person->address->person_id}}</p>
                    <p>Criado em: {{auth()->user()->person->address->created_at}}</p>
                    <p>Atualizado em: {{auth()->user()->person->address->updated_at}}</p>
                @endif
        </div>
        <div class="col-md-4">
                <h4>Suas informações de contato</h4>
                <p>Telefone/Celular: {{auth()->user()->person->phone->number}}</p>
                <p>Tipo: {{auth()->user()->person->phone->phone_type}}</p>
                @if (auth()->user()->profile->profile_name === 'admin')
                    <p>Criado em: {{auth()->user()->person->phone->created_at}}</p>
                    <p>Atualizado em: {{auth()->user()->person->phone->updated_at}}</p>
                @endif
                <hr>
                <h4>Sua identifição</h4>
                <p>CPF/CNPJ: {{auth()->user()->person->identification->identification}}</p>
                @if (auth()->user()->profile->profile_name === 'admin')
                    <p>Person ID: {{auth()->user()->person->identification->person_id}}</p>
                    <p>Criado em: {{auth()->user()->person->identification->created_at}}</p>
                    <p>Atualizado em: {{auth()->user()->person->identification->updated_at}}</p>
                @endif
        </div>
    </div>

    <hr>

    <div class="container">
        <h4>Atualizar endereço:</h4>
        <form  action="{{route('profile', ['updateAction' => 'address'])}}" method="POST">
            @csrf
            <div class="row col-md-6">
                <label for="postal_code" class="col-md-4 col-form-label text-md-end">{{ __('CEP') }}</label>
                <div class="col-md-6"><input id="postal_code" type="text" class="form-control @error('postal_code') is-invalid @enderror" name="postal_code"></div>
                @error('postal_code')<strong>{{ $message }}</strong>@enderror
            </div>
            <div class="row col-md-6">
                <label for="country" class="col-md-4 col-form-label text-md-end">{{ __('País') }}</label>
                <div class="col-md-6"><input id="country" type="text" class="form-control @error('country') is-invalid @enderror" name="country"></div>
                @error('country')<strong>{{ $message }}</strong>@enderror
            </div>
            <div class="row col-md-6">
                <label for="state" class="col-md-4 col-form-label text-md-end">{{ __('Estado/UF') }}</label>
                <div class="col-md-6"><input id="state" type="text" class="form-control @error('state') is-invalid @enderror" name="state"></div>
                @error('state')<strong>{{ $message }}</strong>@enderror
            </div>
            <div class="row col-md-6">
                <label for="city" class="col-md-4 col-form-label text-md-end">{{ __('Cidade') }}</label>
                <div class="col-md-6"><input id="city" type="text" class="form-control @error('city') is-invalid @enderror" name="city"></div>
                @error('city')<strong>{{ $message }}</strong>@enderror
            </div>
            <div class="row col-md-6">
                <label for="neighborhood" class="col-md-4 col-form-label text-md-end">{{ __('Bairro') }}</label>
                <div class="col-md-6"><input id="neighborhood" type="text" class="form-control @error('email') is-invalid @enderror" name="neighborhood"></div>
                @error('email')<strong>{{ $message }}</strong>@enderror
            </div>
            <div class="row col-md-6">
                <label for="street" class="col-md-4 col-form-label text-md-end">{{ __('Rua') }}</label>
                <div class="col-md-6"><input id="street" type="text" class="form-control @error('street') is-invalid @enderror" name="street"></div>
                @error('street')<strong>{{ $message }}</strong>@enderror
            </div>
            <div class="row col-md-6">
                <label for="street_number" class="col-md-4 col-form-label text-md-end">{{ __('Número') }}</label>
                <div class="col-md-6"><input id="street_number" type="number" class="form-control @error('street_number') is-invalid @enderror" name="street_number"></div>
                @error('street_number')<strong>{{ $message }}</strong>@enderror
            </div>
            <div class="row col-md-6">
                <label for="complement" class="col-md-4 col-form-label text-md-end">{{ __('Complemento') }}</label>
                <div class="col-md-6"><input id="complement" type="text" class="form-control @error('complement') is-invalid @enderror" name="complement"></div>
                @error('complement')<strong>{{ $message }}</strong>@enderror
            </div>
            <button type="submit" class="btn btn-primary">
                {{ __('Salvar alterações') }}
            </button>
        </form>
    </div>

    <hr>

    <div class="container">
        <h4>Atualizar dados pessoais:</h4>
        <form method="POST" action="{{route('profile', ['updateAction' => 'person'])}}">
            @csrf

            <div class="row col-md-6">
                <label for="name" class="col-md-4 col-form-label text-md-end">Alterar nome:</label>
                <div class="col-md-6"><input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name"></div>
                @error('name')<strong>{{ $message }}</strong>@enderror
            </div>

            <div class="row col-md-6">
                <label for="birthdate" class="col-md-4 col-form-label text-md-end">{{ __('Nascimento') }}</label>
                <div class="col-md-6"><input id="birthdate" type="date" class="form-control @error('birthdate') is-invalid @enderror" name="birthdate"></div>
                @error('birthdate')<strong>{{ $message }}</strong>@enderror
            </div>

            <button type="submit" class="btn btn-primary">
                {{ __('Salvar alterações') }}
            </button>
        </form>
    </div>
    
    <hr>

    <div class="container">
        <h4>Atualizar identificação</h4>
        <form action="{{route('profile', ['updateAction' => 'identification'])}}" method="post">
            @csrf
            <div class="row col-md-6">
                <label for="identification" class="col-md-4 col-form-label text-md-end">{{ __('CPF/CNPJ') }}</label>
                <div class="col-md-6"><input id="identification" type="text" class="form-control @error('identification') is-invalid @enderror" name="identification"></div>
                @error('identification')<strong>{{ $message }}</strong>@enderror
            </div>

            <button type="submit" class="btn btn-primary">
                {{ __('Salvar alteração') }}
            </button>
        </form>
    </div>

    <hr>

    <hr>

    <div class="container">
        <h4>Atualizar informações de contato:</h4>
        <form action="{{route('profile', ['updateAction' => 'phone'])}}" method="post">
            @csrf
            <div class="row col-md-6">
                <label for="number" class="col-md-4 col-form-label text-md-end">{{ __('Telefone/Celular') }}</label>
                <div class="col-md-6">
                    <input id="number" type="text" class="form-control @error('number') is-invalid @enderror" name="number">
                    @error('email')<strong>{{ $message }}</strong>@enderror
                    <div class="form-check">
                        <input class="form-check-input @error('phone_type') is-invalid @enderror" type="radio" name="phone_type" id="personal" value="personal">
                        <label class="form-check-label" for="personal">
                            Pessoal
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input @error('phone_type') is-invalid @enderror" type="radio" name="phone_type" id="commercial" value="commercial">
                        <label class="form-check-label" for="commercial">
                            Comercial
                        </label>
                    </div>
                    @error('phone_type')<strong>{{ $message }}</strong>@enderror
                </div>
            </div>
            <button type="submit" class="btn btn-primary">
                {{ __('Salvar alteração') }}
            </button>  
        </form>
    </div>

    <hr>

    <div class="container">
        <h4>Atualizar dados de usuário:</h4>
        <form action="{{route('profile', ['updateAction' => 'user'])}}" method="POST">
            @csrf
            @if (auth()->user()->profile->profile_name === 'admin')
                <div class="row col-md-6">
                    <label for="email" class="col-md-4 col-form-label text-md-end">Alterar email:</label>
                    <div class="col-md-6"><input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autocomplete="email"></div>
                    @error('email')<strong>{{ $message }}</strong>@enderror
                </div>

                <div class="row col-md-6">
                    <label for="approver_user_id" class="col-md-4 col-form-label text-md-end">{{ __('Usuário aprovador') }}</label>
                    <div class="col-md-6"><input id="approver_user_id" type="number" class="form-control @error('approver_user_id') is-invalid @enderror" name="approver_user_id" min="0"></div>
                    @error('approver_user_id')<strong>{{ $message }}</strong>@enderror
                </div>    

                <div class="row col-md-6">
                    <label for="approve_limit" class="col-md-4 col-form-label text-md-end">{{ __('Limite de aprovação') }}</label>
                    <div class="col-md-6"><input id="approve_limit" type="number" class="form-control @error('approve_limit') is-invalid @enderror" name="approve_limit" min="1"></div>
                    @error('approve_limit')<strong>{{ $message }}</strong>@enderror
                </div>    
            
                <hr>

                <div>
                    <label class="form-check-label" for="profile_admin">Administrador</label>
                    <input class="form-check-input @error('profile_name') is-invalid @enderror" type="radio" name="profile_name" id="profile_admin" value="admin">
                </div>
                <div>
                    <label class="form-check-label" for="personal">Padrão</label>
                    <input class="form-check-input @error('profile_name') is-invalid @enderror" type="radio" name="profile_name" id="profile_normal" value="normal">
                </div>
                @error('profile_admin')<strong>{{ $message }}</strong>@enderror

                <hr>
            @endif

            <div class="row mb-3">
                <label for="password" class="col-md-4 col-form-label text-md-end">Nova senha:</label>

                <div class="col-md-6">
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="new-password">
                    @error('password')<strong>{{ $message }}</strong>@enderror
                </div>
            </div>

            <div class="row mb-3">
                <label for="password-confirm" class="col-md-4 col-form-label text-md-end">Confirme nova senha:</label>

                <div class="col-md-6">
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" autocomplete="new-password">
                    @error('password-confirm')<strong>{{ $message }}</strong>@enderror
                </div>
            </div>

            <button type="submit" class="btn btn-primary">
                {{ __('Salvar alteração') }}
            </button>  
        </form>
    </div>
</div>
@endsection
