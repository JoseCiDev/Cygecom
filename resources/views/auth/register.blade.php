<x-app>

    <x-slot name="title">
        <h1>Cadastro</h1>
    </x-slot>

    <div class="row">
        <div class="col-sm-12">
            <div class="box box-color box-bordered colored">
                <div class="box-title">
                    <h3 style="color: white; margin-top: 5px">Cadastrar Novo</h3>
                </div>
                <div class="box-content">
                    <form method="POST" action="{{ route('register') }}" class="form-validate" id="bb">
                        @csrf

                        {{-- DADOS PESSOAIS --}}
                        <div class="personal-information">
                            <h3>Dados Pessoais</h3>
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="name" class="control-label"><sup style="color:red">*</sup>Nome</label>
                                        <input type="text" name="name" id="name" placeholder="Nome Completo" class="form-control" data-rule-required="true" data-rule-minlength="2" aria-required="true">
                                        @error('name')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="birthdate" class="control-label">Data de nascimento</label>
                                        <input type="date" name="birthdate" id="birthdate" placeholder="Data de nascimento" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="identification" class="control-label"><sup style="color:red">*</sup>Nº CPF</label>
                                        <input type="text" name="identification" id="identification" data-rule-required="true" placeholder="000.000.000-00" class="form-control mask_cpf">
                                        @error('identification')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="number" class="control-label"><sup style="color:red">*</sup>Telefone/Celular</label>
                                        <input type="text" name="number" id="number" placeholder="(00) 0000-0000" class="form-control mask_phone" data-rule-required="true">
                                        @error('number') <span class="text-danger">{{ $message }}</span>@enderror

                                        <div class="form-group" style="margin: 5px 0px -10px 0px;">
                                            <input class="icheck-me" type="radio" name="phone_type" id="personal" value="personal" data-skin="minimal">
                                            <label class="form-check-label" for="personal">Pessoal</label>
                                            <input class="icheck-me" type="radio" name="phone_type" id="commercial" value="commercial" data-skin="minimal" checked>
                                            <label class="form-check-label" for="commercial">Comercial</label>
                                        </div>


                                        @error('phone_type') <span class="text-danger">{{ $message }}</span> @enderror
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
                                        <input type="text" name="postal_code" id="postal_code" placeholder="00.000-000" class="form-control mask_cep">
                                        @error('postal_code') <p><strong>{{ $message }}</strong></p> @enderror
                                    </div>
                                </div>
                                {{-- PAÍS --}}
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="country" class="control-label">País</label>
                                        <input type="text" name="country" id="country" placeholder="País" class="form-control">
                                        @error('country')<strong>{{ $message }}</strong>@enderror
                                    </div>
                                </div>
                                {{-- ESTADO UF --}}
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="state" class="control-label">Estado/UF</label>
                                        <input type="text" name="state" id="state" placeholder="UF" class="form-control">
                                        @error('state')<strong>{{ $message }}</strong>@enderror
                                    </div>
                                </div>
                                {{-- CIDADE --}}
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="city" class="control-label">Cidade</label>
                                        <input type="text" name="city" id="city" placeholder="Cidade" class="form-control">
                                        @error('city')<strong>{{ $message }}</strong>@enderror
                                    </div>
                                </div>
                                {{-- BAIRRO --}}
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="neighborhood" class="control-label">Bairro</label>
                                        <input type="text" name="neighborhood" id="neighborhood" placeholder="Bairro" class="form-control">
                                        @error('neighborhood')<strong>{{ $message }}</strong>@enderror
                                    </div>
                                </div>
                                {{-- RUA --}}
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="street" class="control-label">Rua</label>
                                        <input type="text" name="street" id="street" placeholder="Rua/Avenida/Servidão" class="form-control">
                                        @error('street')<strong>{{ $message }}</strong>@enderror
                                    </div>
                                </div>
                                {{-- NUMERO --}}
                                <div class="col-sm-1">
                                    <div class="form-group">
                                        <label for="street_number" class="control-label">Número</label>
                                        <input type="number" name="street_number" id="street_number" placeholder="Nº" class="form-control">
                                        @error('street_number')<strong>{{ $message }}</strong>@enderror
                                    </div>
                                </div>
                                {{-- COMPLEMENTO --}}
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="complement" class="control-label">Complemento</label>
                                        <input type="text" name="complement" id="complement" placeholder="ex: casa" class="form-control">
                                        @error('complement')<strong>{{ $message }}</strong>@enderror
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
                                        <label for="email" class="control-label"><sup style="color:red">*</sup>E-mail</label>
                                        <input type="email" name="email" id="email" placeholder="user_email@essentia.com.br" class="form-control @error('email') is-invalid @enderror" data-rule-required="true" data-rule-email="true">
                                        @error('email')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>
                                </div>
                                {{-- SENHA --}}
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="password" class="control-label"><sup style="color:red">*</sup>Senha</label>
                                        <input type="password" name="password" id="password" placeholder="Deve conter ao menos 8 digitos" class="form-control @error('password') is-invalid @enderror" data-rule-required="true" data-rule-minlength="8" autocomplete="new-password">
                                        @error('password')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>
                                </div>
                                {{-- CONFIRMAR SENHA --}}
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="password-confirm" class="control-label"><sup style="color:red">*</sup>Confirmar Senha</label>
                                        <input type="password" name="password_confirmation" id="password-confirm" placeholder="Digite novamente a senha" class="form-control" required autocomplete="new-password">
                                        @error('password_confirmation')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>
                                </div>
                                {{-- PERFIL DE USUÁRIO --}}
                                <div class="col-sm-3">
                                    <label for="form-check" style="margin-bottom: 12px;">Perfil de Usuário</label>
                                    <div class="form-check">
                                        <input class="icheck-me" type="radio" name="profile_type" id="profile_admin" value="admin" data-skin="minimal">
                                        <label class="form-check-label" for="profile_admin">Administrador</label>
                                        <input class="icheck-me" type="radio" name="profile_type" id="profile_normal" value="normal" data-skin="minimal" checked>
                                        <label class="form-check-label" for="personal">Padrão</label>
                                        @error('approve_limit') <p><strong>{{ $message }}</strong></p> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row"></div>
                                {{-- USUÁRIO APROVADOR --}}
                                <div class="col-sm-3" style="padding-left: 0px">
                                    <div class="form-group">
                                        <label for="approver_user_id" class="control-label">Usuário Aprovador</label>
                                        <input type="number" name="approver_user_id" id="approver_user_id" placeholder="ID usuário aprovador" class="form-control">
                                        @error('approver_user_id')<strong>{{ $message }}</strong>@enderror
                                    </div>
                                </div>
                                {{-- LIMITE DE APROVAÇÃO --}}
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="approve_limit" class="control-label">Limite de Aprovação</label>
                                        <input type="number" name="approve_limit" id="approve_limit" placeholder="Valor máximo de aprovação" class="form-control">
                                        @error('approve_limit')<strong>{{ $message }}</strong>@enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- BTNs --}}
                        <div class="form-actions pull-right">
                            <button type="submit" class="btn btn-primary">Salvar</button>
                            <a href="{{ url()->previous() }}" class="btn">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app>
