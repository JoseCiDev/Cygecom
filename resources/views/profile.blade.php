<x-app>
    <x-slot name="title">
        <h1>Informações de perfil</h1>
    </x-slot>
    <div>
        <div class="container">
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
                    <p>CEP: {{auth()->user()->person->address->postal_code}}</p>
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

        <div class="row">
            <div class="col-sm-12">
                <h2>Configurações de perfil</h2>
                <div class="box box-color box-bordered colored">
                    <div class="box-title">
                        <h3>
                            <i class="fa fa-th"></i>Atualizar endereço
                        </h3>
                    </div>
                    <div class="box-content">
                        <form action="{{ route('user', ['id' => auth()->user()->id])  }}" method="POST" class='form-vertical'>
                            @csrf
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="postal_code" class="control-label">CEP</label>
                                        <input id="postal_code" type="text" class="form-control @error('postal_code') is-invalid @enderror" name="postal_code">
                                        @error('postal_code')<strong>{{ $message }}</strong>@enderror
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="country" class="control-label">País</label>
                                        <input id="country" type="text" class="form-control @error('country') is-invalid @enderror" name="country">
                                        @error('country')<strong>{{ $message }}</strong>@enderror
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="state" class="control-label">Estado/UF</label>
                                        <input id="state" type="text" class="form-control @error('state') is-invalid @enderror" name="state">
                                        @error('state')<strong>{{ $message }}</strong>@enderror
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="city" class="control-label">Estado/UF</label>
                                        <input id="city" type="text" class="form-control @error('city') is-invalid @enderror" name="city">
                                        @error('city')<strong>{{ $message }}</strong>@enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="neighborhood" class="control-label">Estado/UF</label>
                                        <input id="neighborhood" type="text" class="form-control @error('neighborhood') is-invalid @enderror" name="neighborhood">
                                        @error('neighborhood')<strong>{{ $message }}</strong>@enderror
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="street" class="control-label">Estado/UF</label>
                                        <input id="street" type="text" class="form-control @error('street') is-invalid @enderror" name="street">
                                        @error('street')<strong>{{ $message }}</strong>@enderror
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="street_number" class="control-label">Estado/UF</label>
                                        <input id="street_number" type="text" class="form-control @error('street_number') is-invalid @enderror" name="street_number">
                                        @error('street_number')<strong>{{ $message }}</strong>@enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-1">
                                    <div class="form-group">
                                        <label for="complement" class="control-label">Estado/UF</label>
                                        <input id="complement" type="text" class="form-control @error('complement') is-invalid @enderror" name="complement">
                                        @error('complement')<strong>{{ $message }}</strong>@enderror
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Salvar alteração</button>
                        </form>
                    </div>
                </div>

                <hr>

                <div class="box box-color box-bordered colored">
                    <div class="box-title">
                        <h3>
                            <i class="fa fa-th"></i>Atualizar dados pessoais
                        </h3>
                    </div>
                    <div class="box-content">
                        <form method="POST" action="{{route('profile', ['updateAction' => 'person'])}}" class='form-vertical'>
                            @csrf
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="name" class="control-label">Alterar nome:</label>
                                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name">
                                        @error('name')<strong>{{ $message }}</strong>@enderror
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="birthdate" class="control-label">Nascimento</label>
                                        <input id="birthdate" type="date" class="form-control @error('birthdate') is-invalid @enderror" name="birthdate">
                                        @error('birthdate')<strong>{{ $message }}</strong>@enderror
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Salvar alteração</button>
                        </form>
                    </div>
                </div>

                <hr>

                <div class="box box-color box-bordered colored">
                    <div class="box-title">
                        <h3>
                            <i class="fa fa-th"></i>Atualizar identificação
                        </h3>
                    </div>
                    <div class="box-content">
                        <form action="{{ route('user', ['id' => auth()->user()->id]) }}" method="post" class='form-vertical'>
                            @csrf
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="identification" class="control-label">CPF/CNPJ</label>
                                        <input id="identification" type="text" class="form-control @error('identification') is-invalid @enderror" name="identification">
                                        @error('identification')<strong>{{ $message }}</strong>@enderror
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Salvar alteração</button>
                        </form>
                    </div>
                </div>

                <hr>

                <div class="box box-color box-bordered colored">
                    <div class="box-title">
                        <h3>
                            <i class="fa fa-th"></i>Atualizar informações de contato:
                        </h3>
                    </div>
                    <div class="box-content">
                        <form action="{{ route('user', ['id' => auth()->user()->id])  }}" method="post" class='form-vertical'>
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group col-md-3">
                                        <label for="number" class="control-label">Telefone/Celular</label>
                                        <input id="number" type="text" class="form-control @error('number') is-invalid @enderror" name="number">
                                        @error('number')<strong>{{ $message }}</strong>@enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <div class="col-md-12">
                                            <label class="control-label">Tipo</label>
                                            <div class="radio">
                                                <label>
                                                    <input class="@error('phone_type') is-invalid @enderror" type="radio" name="phone_type" id="personal" value="personal">
                                                    Pessoal
                                                </label>
                                            </div>
                                            <div class="radio">
                                                <label>
                                                    <input class="@error('phone_type') is-invalid @enderror" type="radio" name="phone_type" id="commercial" value="commercial">
                                                    Comercial
                                                </label>
                                            </div>
                                        </div>
                                        @error('phone_type')<strong>{{ $message }}</strong>@enderror
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Salvar alteração</button>
                        </form>
                    </div>
                </div>

                <hr>

                <div class="box box-color box-bordered colored">
                    <div class="box-title">
                        <h3>
                            <i class="fa fa-th"></i>Atualizar dados de usuário:
                        </h3>
                    </div>
                    <div class="box-content">
                        <form action="{{ route('user', ['id' => auth()->user()->id])  }}" method="POST" class='form-vertical'>
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    @if (auth()->user()->profile->profile_name === 'admin')
                                        <div class="form-group col-md-3">
                                            <label for="email" class="control-label">Alterar email:</label>
                                            <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email">
                                            @error('email')<strong>{{ $message }}</strong>@enderror
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label for="approver_user_id" class="control-label">Usuário aprovador</label>
                                            <input id="approver_user_id" type="text" class="form-control @error('approver_user_id') is-invalid @enderror" name="approver_user_id">
                                            @error('approver_user_id')<strong>{{ $message }}</strong>@enderror
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label for="approve_limit" class="control-label">Limite de aprovação</label>
                                            <input id="approve_limit" type="text" class="form-control @error('approve_limit') is-invalid @enderror" name="approve_limit">
                                            @error('approve_limit')<strong>{{ $message }}</strong>@enderror
                                        </div>

                                        <div class="form-group col-md-3">
                                            <div class="col-md-12">
                                                <label class="control-label">Perfil</label>
                                                <div class="radio">
                                                    <label>
                                                        <input class="@error('profile_name') is-invalid @enderror" type="radio" name="profile_name" id="profile_admin" value="admin">
                                                        Administrador
                                                    </label>
                                                </div>
                                                <div class="radio">
                                                    <label>
                                                        <input class="@error('profile_name') is-invalid @enderror" type="radio" name="profile_name" id="profile_normal" value="normal">
                                                        Normal
                                                    </label>
                                                </div>
                                            </div>
                                            @error('phone_type')<strong>{{ $message }}</strong>@enderror
                                        </div>
                                    @endif

                                    <div class="form-group col-md-3">
                                        <label for="approve_limit" class="control-label">Nova senha:</label>
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="new-password">
                                        @error('password')<strong>{{ $message }}</strong>@enderror
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label for="approve_limit" class="control-label">Confirme nova senha:</label>
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" autocomplete="new-password">
                                        @error('password-confirm')<strong>{{ $message }}</strong>@enderror
                                    </div>

                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Salvar alteração</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app>
