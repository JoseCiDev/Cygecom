<form method="POST" action="{{ route($action, $user['id']) }}">
    @csrf

    {{-- DADOS PESSOAIS --}}
    <div class="personal-information">
        <h3>Dados pessoais</h3>
        <div class="row">
            <div class="col-sm-3">
                <div class="form-group">
                    <label for="name" class="control-label">Nome</label>
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{$person['name']}}" placeholder="Nome completo">
                    @error('name') <strong>{{ $message }}</strong>@enderror
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    <label for="birthdate" class="control-label">Data de nascimento</label>
                    <input id="birthdate" type="date" class="form-control @error('birthdate') is-invalid @enderror" name="birthdate" value="{{$person['birthdate']}}">
                    @error('name') <strong>{{ $message }}</strong>@enderror
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    <label for="identification" class="control-label">Nº CPF</label>
                    <input id="identification" type="text" class="form-control @error('identification') is-invalid @enderror" name="identification" value="{{$person['identification']}}" placeholder="000.000.000-00">
                    @error('name') <strong>{{ $message }}</strong>@enderror
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    <label for="number" class="control-label">Telefone/Celular</label>
                    <input id="" type="text" class="form-control mb-3 @error('number') is-invalid @enderror" name="number" value="{{$phone['number']}}" placeholder="(DDD) 00000-0000">
                    @error('number') <strong>{{ $message }}</strong>@enderror

                    <input  @if ($phone['phone_type'] === "personal") {{"checked"}} @endif
                    class="form-check-input" type="radio" name="phone_type" id="personal" value="personal" >
                    <label class="form-check-label" for="personal">Pessoal</label>

                    <input @if ($phone['phone_type'] === "commercial") {{"checked"}} @endif
                    class="form-check-input" type="radio" name="phone_type" id="commercial" value="commercial">
                    <label class="form-check-label" for="commercial">Comercial</label>
                    @error('phone_type') <p><strong>{{ $message }}</strong></p> @enderror
                </div>
            </div>
        </div>
    </div>

    <hr>

    {{-- DADOS DE ENDEREÇO --}}
    <div class="address-information">
        <h3>Endereço</h3>
        {{-- CEP --}}
        <div class="row">
            <div class="col-sm-2">
                <div class="form-group">
                    <label for="postal_code" class="control-label">CEP</label>
                    <input id="postal_code" type="text" class="form-control" name="postal_code" value="{{$address['postal_code']}}" placeholder="00.000-000">
                    @error('postal_code') <strong>{{ $message }}</strong>@enderror
                </div>
            </div>
            {{-- PAÍS --}}
            <div class="col-sm-3">
                <div class="form-group">
                    <label for="country" class="control-label">País</label>
                    <input id="country" type="text" class="form-control" name="country" value="{{$address['country']}}">
                    @error('country') <strong>{{ $message }}</strong>@enderror
                </div>
            </div>
            {{-- ESTADO UF --}}
            <div class="col-sm-3">
                <div class="form-group">
                    <label for="state" class="control-label">Estado/UF</label>
                    <input id="state" type="text" class="form-control" name="state" value="{{$address['state']}}" placeholder="UF">
                    @error('state') <strong>{{ $message }}</strong>@enderror
                </div>
            </div>
            {{-- CIDADE --}}
            <div class="col-sm-3">
                <div class="form-group">
                    <label for="city" class="control-label">Cidade</label>
                    <input id="city" type="text" class="form-control" name="city" value="{{$address['city']}}" placeholder="Cidade">
                    @error('city') <strong>{{ $message }}</strong>@enderror
                </div>
            </div>
            {{-- BAIRRO --}}
            <div class="col-sm-4">
                <div class="form-group">
                    <label for="neighborhood" class="control-label">Bairro</label>
                    <input id="neighborhood" type="text" class="form-control" name="neighborhood" value="{{$address['neighborhood']}}" placeholder="Bairro">
                    @error('neighborhood') <strong>{{ $message }}</strong>@enderror
                </div>
            </div>
            {{-- RUA --}}
            <div class="col-sm-4">
                <div class="form-group">
                    <label for="street" class="control-label">Rua</label>
                    <input id="street" type="text" class="form-control" name="street" value="{{$address['street']}}" placeholder="Rua/Avenida/Servidão">
                    @error('street') <strong>{{ $message }}</strong>@enderror
                </div>
            </div>
            {{-- NUMERO --}}
            <div class="col-sm-1">
                <div class="form-group">
                    <label for="street_number" class="control-label">Número</label>
                    <input id="street_number" type="number" class="form-control" name="street_number" value="{{$address['street_number']}}" placeholder="Nº">
                    @error('street_number') <strong>{{ $message }}</strong>@enderror
                </div>
            </div>
            {{-- COMPLEMENTO --}}
            <div class="col-sm-3">
                <div class="form-group">
                    <label for="complement" class="control-label">Complemento</label>
                    <input id="complement" type="text" class="form-control" name="complement" value="{{$address['complement']}}" placeholder="Ex.: Casa, Apt, Condomínio">
                    @error('complement') <strong>{{ $message }}</strong>@enderror
                </div>
            </div>
        </div>
    </div>

    <hr>

    {{-- DADOS DE USUÁRIO --}}
    <div class="user-information">
        <h3>Dados de Usuário</h3>
        <div class="row">
            {{-- E-MAIL --}}
            <div class="col-sm-3">
                <div class="form-group">
                    <label for="email" class="control-label">E-mail</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{$user['email']}}" placeholder="seu_email@essentia.com.br">
                    @error('email') <strong>{{ $message }}</strong>@enderror
                </div>
            </div>
            {{-- SENHA --}}
            <div class="col-sm-3">
                <div class="form-group">
                    <label for="password" class="control-label">Senha</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="new-password" placeholder="Deve conter ao menos 8 dígitos">
                    @error('password')<strong>{{ $message }}</strong>@enderror
                </div>
            </div>
            {{-- CONFIRMAR SENHA --}}
            <div class="col-sm-3">
                <div class="form-group">
                    <label for="password-confirm" class="control-label">Confirmar Senha</label>
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" autocomplete="new-password" placeholder="Digite novamente a senha">
                    @error('password-confirm')<strong>{{ $message }}</strong>@enderror
                </div>
            </div>

            @if ($profile['name'] === 'admin')
                {{-- USUÁRIO APROVADOR --}}
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="approver_user_id" class="control-label">Usuário Aprovador</label>
                        <input id="approver_user_id" type="number" class="form-control @error('approver_user_id') is-invalid @enderror" name="approver_user_id" min="0" placeholder="ID usuário aprovador"
                            @if (isset($user['approver_user_id'])) value="{{$user['approver_user_id']}}" @endif >
                        @error('approver_user_id') <strong>{{ $message }}</strong>@enderror
                    </div>
                </div>
                {{-- LIMITE DE APROVAÇÃO --}}
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="approve_limit" class="control-label">Limite de Aprovação</label>
                        <input id="approve_limit" type="number" class="form-control @error('approve_limit') is-invalid @enderror" name="approve_limit" min="1" value="{{$user['approve_limit']}}" placeholder="Valor máximo de aprovação">
                        @error('approve_limit') <strong>{{ $message }}</strong>@enderror
                    </div>
                </div>
                {{-- PERFIL DE USUÁRIO --}}
                <div class="col-sm-4">
                    <h5>Perfil de Usuário</h5>
                    <div class="form-check">
                        <input @if ($profile['name'] === "admin") {{"checked"}}@endif
                            class="form-check-input" type="radio" name="profile_type" id="profile_admin" value="admin">
                        <label class="form-check-label" for="profile_admin">Administrador</label>

                        <input @if ($profile['name'] === "normal") {{"checked"}} @endif
                            class="form-check-input" type="radio" name="profile_type" id="profile_normal" value="normal">
                        <label class="form-check-label" for="personal">Padrão</label>
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- BTNs --}}
    <div class="form-actions pull-right">
        <button type="submit" class="btn btn-primary">Atualizar usuário</button>
        <a href="{{ url()->previous() }}" class="btn">Cancelar</a>
    </div>
</form>
