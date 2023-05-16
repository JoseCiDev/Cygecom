<div class="box-title">
    <h3 style="color: white; margin-top: 5px">
        @if (isset($user)) Atualizar usuário
        @else Editar usuário @endif
    </h3>
</div>
<div class="box-content">
    @if (isset($user))
        {{-- if has user -> update --}}
        <form method="POST" action="{{ route($action, $user['id']) }}" class="form-validate" id="form-update">
    @else
        {{-- if hasn't -> register --}}
        <form method="POST" action="{{ route('register') }}" class="form-validate" id="form-register">
    @endif
        @csrf

        {{-- DADOS PESSOAIS --}}
        <div class="personal-information">
            <h3>Dados Pessoais</h3>
            <div class="row">
                {{-- NOME --}}
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="name" class="control-label"><sup style="color:red">*</sup>Nome</label>
                        <input
                        type="text"
                        name="name"
                        id="name"
                        placeholder="Nome Completo"
                        class="form-control"
                        data-rule-required="true"
                        data-rule-minlength="2"
                        @if (isset($user))
                            value="{{ $user['person']['name']}}"
                        @endif >
                        @error('name')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                </div>
                {{-- DATA NASCIMENTO --}}
                <div class="col-sm-3">
                        <div class="form-group">
                            <label for="birthdate" class="control-label">Data de nascimento</label>
                            <input
                            type="date"
                            name="birthdate"
                            id="birthdate"
                            placeholder="Data de nascimento"
                            class="form-control"
                            @if (isset($user))
                                value="{{ $user['person']['birthdate'] }}"
                            @endif >
                        </div>
                    </div>
                    {{-- DOCUMENTO --}}
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="identification" class="control-label"><sup style="color:red">*</sup>Nº CPF</label>
                            <input
                            type="text"
                            name="identification"
                            id="identification"
                            data-rule-required="true"
                            placeholder="000.000.000-00"
                            class="form-control mask_cpf"
                            @if (isset($user))
                                value="{{ $user['person']['identification']['identification'] }}"
                            @endif >
                            @error('identification')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    {{-- PHONE --}}
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="number" class="control-label"><sup style="color:red">*</sup>Telefone/Celular</label>
                            <input
                            type="text"
                            name="number"
                            id="number"
                            placeholder="(00) 0000-0000"
                            class="form-control mask_phone"
                            data-rule-required="true"
                            @if (isset($user))
                                value="{{ $user['person']['phone']['number'] }}"
                            @endif >
                            @error('number') <span class="text-danger">{{ $message }}</span>@enderror
                            <div class="form-group" style="margin: 5px 0px -10px 0px;">
                                {{-- PESSOAL --}}
                                <input
                                @if(isset($user))
                                    @if ($user['person']['phone']['phone_type']  === "personal") {{"checked"}} @endif
                                @endif
                                    class="icheck-me"
                                    type="radio"
                                    name="phone_type"
                                    id="personal"
                                    value="personal"
                                    data-skin="minimal">
                                <label class="form-check-label" for="personal">Pessoal</label>
                                {{-- COMERCIAL --}}
                                <input
                                @if(isset($user))
                                    @if ($user['person']['phone']['phone_type'] === "commercial") {{"checked"}} @endif
                                @endif
                                class="icheck-me"
                                type="radio"
                                name="phone_type"
                                id="commercial"
                                value="commercial"
                                data-skin="minimal"
                                @if(!isset($user)) checked @endif >
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
                            <input
                            type="text"
                            name="postal_code"
                            id="postal_code"
                            placeholder="00.000-000"
                            class="form-control mask_cep"
                            @if(isset($user))
                                value="{{ $user['person']['address']['postal_code'] }}"
                            @endif >
                            @error('postal_code') <p><strong>{{ $message }}</strong></p> @enderror
                        </div>
                    </div>
                    {{-- PAÍS --}}
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="country" class="control-label">País</label>
                            <input
                            type="text"
                            name="country"
                            id="country"
                            placeholder="País"
                            class="form-control"
                            @if(isset($user))
                                value="{{ $user['person']['address']['country'] }}"
                            @endif >
                            @error('country')<strong>{{ $message }}</strong>@enderror
                        </div>
                    </div>
                    {{-- ESTADO UF --}}
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="state" class="control-label">Estado/UF</label>
                            <input
                            type="text"
                            name="state"
                            id="state"
                            placeholder="UF"
                            class="form-control"
                            @if(isset($user))
                                value="{{ $user['person']['address']['state'] }}"
                            @endif >
                            @error('state')<strong>{{ $message }}</strong>@enderror
                        </div>
                    </div>
                    {{-- CIDADE --}}
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="city" class="control-label">Cidade</label>
                            <input
                            type="text"
                            name="city"
                            id="city"
                            placeholder="Cidade"
                            class="form-control"
                            @if(isset($user))
                                value="{{ $user['person']['address']['city'] }}"
                            @endif >
                            @error('city')<strong>{{ $message }}</strong>@enderror
                        </div>
                    </div>
                    {{-- BAIRRO --}}
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="neighborhood" class="control-label">Bairro</label>
                            <input
                            type="text"
                            name="neighborhood"
                            id="neighborhood"
                            placeholder="Bairro"
                            class="form-control"
                            @if(isset($user))
                                value="{{ $user['person']['address']['neighborhood'] }}"
                            @endif >
                            @error('neighborhood')<strong>{{ $message }}</strong>@enderror
                        </div>
                    </div>
                    {{-- RUA --}}
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="street" class="control-label">Rua</label>
                            <input
                            type="text"
                            name="street"
                            id="street"
                            placeholder="Rua/Avenida/Servidão"
                            class="form-control"
                            @if(isset($user))
                                value="{{ $user['person']['address']['street'] }}"
                            @endif >
                            @error('street')<strong>{{ $message }}</strong>@enderror
                        </div>
                    </div>
                    {{-- NUMERO --}}
                    <div class="col-sm-1">
                        <div class="form-group">
                            <label for="street_number" class="control-label">Número</label>
                            <input
                            type="number"
                            name="street_number"
                            id="street_number"
                            placeholder="Nº"
                            class="form-control"
                            @if(isset($user))
                                value="{{ $user['person']['address']['street_number'] }}"
                            @endif >
                            @error('street_number')<strong>{{ $message }}</strong>@enderror
                        </div>
                    </div>
                    {{-- COMPLEMENTO --}}
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="complement" class="control-label">Complemento</label>
                            <input
                            type="text"
                            name="complement"
                            id="complement"
                            placeholder="ex: casa"
                            class="form-control"
                            @if(isset($user))
                                value="{{ $user['person']['address']['complement'] }}"
                            @endif >
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
                            <input
                            type="email"
                            name="email"
                            id="email"
                            placeholder="user_email@essentia.com.br"
                            @if(isset($user))
                                value="{{ $user['email'] }}"
                            @endif
                            class="form-control
                            @error('email') is-invalid @enderror" data-rule-required="true" data-rule-email="true">
                            @error('email')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    {{-- SENHA --}}
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="password" class="control-label"><sup style="color:red">*</sup>Senha</label>
                            <input
                            type="password"
                            name="password"
                            id="password"
                            placeholder="Deve conter ao menos 8 digitos"
                            @if(!isset($user))
                                data-rule-required="true"
                                data-rule-minlength="8"
                                class="form-control no-validation @error('password') is-invalid @enderror"
                            @else
                                class="form-control no-validation @error('password') is-invalid @enderror"
                            @endif
                            autocomplete="new-password">
                            @error('password')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    {{-- CONFIRMAR SENHA --}}
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="password-confirm" class="control-label"><sup style="color:red">*</sup>Confirmar Senha</label>
                            <input
                            type="password"
                            name="password_confirmation"
                            id="password-confirm"
                            placeholder="Digite novamente a senha"
                            @if(!isset($user))
                                class="form-control"
                                required
                            @else
                                class="form-control no-validation"
                            @endif
                            autocomplete="new-password">
                            @error('password_confirmation')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    {{-- PERFIL DE USUÁRIO --}}
                    <div class="col-sm-3">
                        <label for="form-check" style="margin-bottom: 12px;">Perfil de Usuário</label>
                        <div class="form-check">
                            {{-- ADMIN --}}
                            <input @if (isset($user) && $user['profile']['name'] === "admin") {{"checked"}}@endif
                            class="icheck-me" type="radio" name="profile_type" id="profile_admin" value="admin" data-skin="minimal">
                            <label class="form-check-label" for="profile_admin">Administrador</label>
                            {{-- PADRÃO --}}
                            <input @if (isset($user) && $user['profile']['name'] === "normal") {{"checked"}} @endif
                            class="icheck-me" type="radio" name="profile_type" id="profile_normal" value="normal" data-skin="minimal"
                            @if (!isset($user)) checked @endif>
                            <label class="form-check-label" for="personal">Padrão</label>
                            @error('approve_limit') <p><strong>{{ $message }}</strong></p> @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    {{-- CENTRO DE CUSTO --}}
                    <div class="col-sm-3">
                        <label for="cost_center_id" class="control-label"><sup style="color:red">*</sup>Setor</label>
                        @if (isset($user))
                            <select name="cost_center_id" id="cost_center_id" class='chosen-select form-control @error('cost_center_id') is-invalid @enderror' required data-rule-required="true" data-rule-email="true">
                                <option value="" disabled selected>Selecione uma opção/option>
                                @foreach($costCenters as $costCenter)
                                    <option value="{{ $costCenter->id }}"
                                        {{ $user['cost_center_id'] == $costCenter->id ? 'selected' : '' }}>
                                        {{ $costCenter->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('cost_center_id')<span class="text-danger">{{ $message }}</span>@enderror
                        @else
                            <select name="cost_center_id" id="cost_center_id" class='chosen-select form-control' >
                                <option value="" disabled selected>Selecione uma opção </option>
                                @foreach($costCenters as $costCenter)
                                    <option value="{{ $costCenter->id  }}">
                                        {{ $costCenter->name }}
                                    </option>
                                @endforeach
                            </select>
                        @endif
                    </div>
                    {{-- USUÁRIO APROVADOR --}}
                    <div class="col-sm-3">
                        <label for="approver_user_id" class="control-label">Usuário aprovador</label>
                        @if (isset($user))
                            <select name="approver_user_id" id="approver_user_id" class="chosen-select form-control" >
                                <option value="" disabled selected>Selecione uma opção </option>
                                @foreach($approvers as $approver)
                                    <option value="{{ $approver['id'] }}"
                                        {{ $user['approver_user_id'] == $approver['id'] ? 'selected' : '' }}>
                                        {{ $approver['person']['name'] }}
                                    </option>
                                @endforeach
                            </select>
                        @else
                            <select name="approver_user_id" id="approver_user_id" class="chosen-select form-control" >
                                <option value="" disabled selected>Selecione uma opção </option>
                                @foreach($approvers as $approver)
                                    <option value="{{ $approver['id'] }}">
                                        {{ $approver['person']['name'] }}
                                    </option>
                                @endforeach
                            </select>
                        @endif
                    </div>
                    {{-- LIMITE DE APROVAÇÃO --}}
                    <div class="col-sm-5">
                        <div class="form-group">
                            <label for="approve_limit" class="control-label">
                                Limite de Aprovação
                            </label>
                            @if (isset($user))
                                <input
                                    id="approve_limit"
                                    name="approve_limit"
                                    type="range" style="accent-color: #204e81;"
                                    step="5000" min="0" max="100000"
                                    value="{{ $user['approve_limit'] }}"
                                    class="no-validation">
                            @else
                                <input
                                    id="approve_limit"
                                    name="approve_limit"
                                    type="range" style="accent-color: #204e81;"
                                    step="5000" min="0" max="100000"
                                    value="0" class="no-validation">
                            @endif
                            <span id="rangeValue">até R$ {{ isset($user) ? $user['approve_limit'] : '0' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- BTNs --}}
            <div class="form-actions pull-right">
                <button type="submit" class="btn btn-primary">Salvar</button>
                <a href="{{ route('users') }}" class="btn">Cancelar</a>
            </div>
        </form>
    </div>
</div>

{{-- SLIDER JS --}}
<script>
    function formatRangeValue(val) {
        const rangeValue = $('#rangeValue');
        rangeValue.text('até R$ ' + val.toLocaleString('pt-BR'));
    }
    $(function() {
        const range = $('#approve_limit');
        const hiddenInput = $('#approve_limit');
        range.attr('step', '5000');
        const val = parseInt(range.val());
        const step = val > 50000 ? 10000 : 5000;
        range.attr({ step });
        formatRangeValue(val);
        hiddenInput.val(val); // atualiza o valor do input hidden
        range.on('input', function() {
            const val = parseInt(range.val());
            const step = val > 50000 ? 10000 : 5000;
            range.attr({ step });
            formatRangeValue(val);
            hiddenInput.val(val); // atualiza o valor do input hidden
        });
    });
</script>

