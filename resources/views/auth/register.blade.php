<x-app>

    <x-slot name="title">
        <h1>Register</h1>
    </x-slot>

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="box box-color box-bordered colored">
                    <div class="box-title">
                        <h2 style="color: white; margin-top: 5px">Cadastrar Novo</h2>
                    </div>
                    <div class="box-content">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            {{-- DADOS PESSOAIS --}}
                            <div class="personal-information">
                                <h3>Dados Pessoais</h3>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="name" class="control-label">Nome</label>
                                            <input type="text" name="name" id="name" placeholder="Nome Completo" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="birthdate" class="control-label">Data de nascimento</label>
                                            <input type="date" name="birthdate" id="birthdate" placeholder="Data de nascimento" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="document_number" class="control-label">Nº CPF</label>
                                            <input type="text" name="document_number" id="document_number" placeholder="000.000.000-00" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="phone" class="control-label">Telefone/Celular</label>
                                            <input type="text" name="phone" id="phone" placeholder="(DDD) 0000-0000" class="form-control">
                                            <input class="form-check-input" type="radio" name="phone_type" id="personal" value="personal" checked>
                                            <label class="form-check-label" for="personal">
                                                Pessoal
                                            </label>
                                            <input class="form-check-input" type="radio" name="phone_type" id="commercial" value="commercial">
                                            <label class="form-check-label" for="commercial">
                                                Comercial
                                            </label>
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
                                            <input type="text" name="postal_code" id="postal_code" placeholder="00.000-000" class="form-control" required>
                                        </div>
                                    </div>
                                    {{-- PAÍS --}}
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="country" class="control-label">País</label>
                                            <input type="text" name="country" id="country" placeholder="País" class="form-control" required>
                                        </div>
                                    </div>
                                    {{-- ESTADO UF --}}
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="state" class="control-label">Estado/UF</label>
                                            <input type="text" name="state" id="state" placeholder="UF" class="form-control" required>
                                        </div>
                                    </div>
                                    {{-- CIDADE --}}
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="city" class="control-label">Cidade</label>
                                            <input type="text" name="city" id="city" placeholder="Cidade" class="form-control" required>
                                        </div>
                                    </div>
                                    {{-- BAIRRO --}}
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="neighborhood" class="control-label">Bairro</label>
                                            <input type="text" name="neighborhood" id="neighborhood" placeholder="Bairro" class="form-control" required>
                                        </div>
                                    </div>
                                    {{-- RUA --}}
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="street" class="control-label">Rua</label>
                                            <input type="text" name="street" id="street" placeholder="Rua/Avenida/Servidão" class="form-control" required>
                                        </div>
                                    </div>
                                    {{-- NUMERO --}}
                                    <div class="col-sm-1">
                                        <div class="form-group">
                                            <label for="street_number" class="control-label">Número</label>
                                            <input type="number" name="street_number" id="street_number" placeholder="Nº" class="form-control" required>
                                        </div>
                                    </div>
                                    {{-- COMPLEMENTO --}}
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="complement" class="control-label">Complemento</label>
                                            <input type="text" name="complement" id="complement" placeholder="ex: casa" class="form-control">
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
                                            <input type="email" name="email" id="email" placeholder="user_email@essentia.com.br" class="form-control @error('email') is-invalid @enderror" required autocomplete="email">
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    {{-- SENHA --}}
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="password" class="control-label">Senha</label>
                                            <input type="password" name="password" id="password" placeholder="Deve conter ao menos 8 digitos" class="form-control @error('password') is-invalid @enderror" required autocomplete="new-password">
                                        </div>
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    {{-- CONFIRMAR SENHA --}}
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="password-confirm" class="control-label">Confirmar Senha</label>
                                            <input type="password" name="password_confirmation" id="password-confirm" placeholder="Digite novamente a senha" class="form-control" required autocomplete="new-password">
                                        </div>
                                    </div>
                                    {{-- USUÁRIO APROVADOR --}}
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="approver_user_id" class="control-label">Usuário Aprovador</label>
                                            <input type="number" name="approver_user_id" id="approver_user_id" placeholder="ID usuário aprovador" class="form-control">
                                        </div>
                                    </div>
                                    {{-- LIMITE DE APROVAÇÃO --}}
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="approve_limit" class="control-label">Limite de Aprovação</label>
                                            <input type="number" name="approve_limit" id="approve_limit" placeholder="Valor máximo de aprovação" class="form-control">
                                        </div>
                                    </div>
                                    {{-- PERFIL DE USUÁRIO --}}
                                    <div class="col-sm-4">
                                        <h5>Perfil de Usuário</h5>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="profile_type" id="profile_admin" value="admin" checked>
                                            <label class="form-check-label" for="profile_admin">Administrador</label>
                                            <input class="form-check-input" type="radio" name="profile_type" id="profile_normal" value="normal">
                                            <label class="form-check-label" for="personal">Padrão</label>
                                        </div>
                                    </div>
                                </div>
                            </div>   
                            {{-- BTNs --}}
                            <div class="form-actions pull-right">
                                <button type="submit" class="btn btn-primary">Salvar</button>
                                <button type="button" class="btn">Cancelar</button>
                            </div> 
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app>
