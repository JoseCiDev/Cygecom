<div class="box-title">
    <div class="row">
        <div class="col-md-6">
            <h3 style="color: white; margin-top: 5px">
                @if (isset($user)) Atualizar usuário
                @else
                    Editar usuário @endif
            </h3>
        </div>
        @if (isset($user) && auth()->user()->id !== $user['id'])
            <div class="col-md-6 pull-right">
                <x-modalDelete />
                <button data-route="user" data-name="{{ $user['person']['name'] }}" data-id="{{ $user['id'] }}"
                    data-toggle="modal" data-target="#modal" rel="tooltip" title="Excluir"
                    class="btn btn-danger pull-right" style="margin-right: 15px">
                    Excluir usuário
                </button>
            </div>
        @endif
    </div>
</div>
<div class="box-content">
    @if (isset($user))
        <form method="POST" action="{{ route($action, $user['id']) }}" class="form-validate" id="form-update">
        @else
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
                    <input type="text" name="name" id="name" placeholder="Nome Completo" class="form-control"
                        data-rule-required="true" data-rule-minlength="2"
                        @if (isset($user)) value="{{ $user['person']['name'] }}" @endif>
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            {{-- DATA NASCIMENTO --}}
            <div class="col-sm-3">
                <div class="form-group">
                    <label for="birthdate" class="control-label">Data de nascimento</label>
                    <input type="date" name="birthdate" id="birthdate" placeholder="Data de nascimento"
                        class="form-control"
                        @if (isset($user)) value="{{ $user['person']['birthdate'] }}" @endif>
                </div>
            </div>
            {{-- DOCUMENTO --}}
            <div class="col-sm-3">
                <div class="form-group">
                    <label for="cpf_cnpj" class="control-label"><sup style="color:red">*</sup>Nº CPF</label>
                    <input type="text" name="cpf_cnpj" id="cpf_cnpj" data-rule-required="true"
                        placeholder="000.000.000-00" class="form-control mask_cpf"
                        @if (isset($user)) value="{{ $user['person']['cpf_cnpj'] }}" @endif>
                    @error('cpf_cnpj')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            {{-- PHONE --}}
            <div class="col-sm-3">
                <div class="form-group">
                    <label for="number" class="control-label">
                        <sup style="color:red">*</sup>Telefone/Celular
                    </label>
                    <input type="text" name="number" id="number" placeholder="(00) 0000-0000"
                        class="form-control mask_phone" data-rule-required="true"
                        @if (isset($user)) value="{{ $user['person']['phone']['number'] }}" @endif>
                    @error('number')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                    <div class="form-group" style="margin: 5px 0px -10px 0px;">
                        {{-- PESSOAL --}}
                        <input
                            @if (isset($user)) @if ($user['person']['phone']['phone_type'] === 'personal') {{ 'checked' }} @endif
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
                            @if (isset($user)) @if ($user['person']['phone']['phone_type'] === 'commercial') {{ 'checked' }} @endif
                            @endif
                        class="icheck-me"
                        type="radio"
                        name="phone_type"
                        id="commercial"
                        value="commercial"
                        data-skin="minimal"
                        @if (!isset($user)) checked @endif >
                        <label class="form-check-label" for="commercial">Comercial</label>
                    </div>
                    @error('phone_type')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
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
                    <input type="email" name="email" id="email" placeholder="user_email@essentia.com.br"
                        @if (isset($user)) value="{{ $user['email'] }}" @endif
                        class="form-control
                            @error('email') is-invalid @enderror"
                        data-rule-required="true" data-rule-email="true">
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            {{-- SENHA --}}
            <div class="col-sm-3">
                <div class="form-group">
                    <label for="password" class="control-label"><sup style="color:red">*</sup>Senha</label>
                    <input type="password" name="password" id="password"
                        placeholder="Deve conter ao menos 8 digitos"
                        @if (!isset($user)) data-rule-required="true"
                                data-rule-minlength="8"
                                class="form-control no-validation @error('password') is-invalid @enderror"
                            @else
                                class="form-control no-validation @error('password') is-invalid @enderror" @endif
                        autocomplete="new-password">
                    @error('password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            {{-- CONFIRMAR SENHA --}}
            <div class="col-sm-3">
                <div class="form-group">
                    <label for="password-confirm" class="control-label"><sup style="color:red">*</sup>Confirmar
                        Senha</label>
                    <input type="password" name="password_confirmation" id="password-confirm"
                        placeholder="Digite novamente a senha"
                        @if (!isset($user)) class="form-control"
                                required
                            @else
                                class="form-control no-validation" @endif
                        autocomplete="new-password">
                    @error('password_confirmation')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            {{-- PERFIL DE USUÁRIO --}}
            <div class="col-sm-3">
                <label for="form-check" style="margin-bottom: 12px;">Perfil de Usuário</label>
                <div class="form-check">
                    {{-- ADMIN --}}
                    <input @if (isset($user) && $user['profile']['name'] === 'admin') {{ 'checked' }} @endif class="icheck-me"
                        type="radio" name="profile_type" id="profile_admin" value="admin" data-skin="minimal">
                    <label class="form-check-label" for="profile_admin">Administrador</label>
                    {{-- PADRÃO --}}
                    <input @if (isset($user) && $user['profile']['name'] === 'normal') {{ 'checked' }} @endif class="icheck-me"
                        type="radio" name="profile_type" id="profile_normal" value="normal" data-skin="minimal"
                        @if (!isset($user)) checked @endif>
                    <label class="form-check-label" for="personal">Padrão</label>
                    @error('approve_limit')
                        <p><strong>{{ $message }}</strong></p>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4">
                <label for="cost_center_id" class="control-label"><sup style="color:red">*</sup>Setor</label>
                @if (isset($user))
                    <select name="cost_center_id" id="cost_center_id"
                        class='chosen-select form-control @error('cost_center_id') is-invalid @enderror' required
                        data-rule-required="true">
                        <option value="" disabled {{ isset($user->person->costCenter) ? '' : 'selected' }}>
                            Selecione uma opção</option>
                        @foreach ($costCenters as $costCenter)
                            <option value="{{ $costCenter->id }}"
                                {{ isset($user->person->costCenter) && $user->person->costCenter->id == $costCenter->id ? 'selected' : '' }}>
                                {{ $costCenter->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('cost_center_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                @else
                    <select name="cost_center_id" id="cost_center_id" class='chosen-select form-control'>
                        <option value="" disabled selected>Selecione uma opção </option>
                        @foreach ($costCenters as $costCenter)
                            <option value="{{ $costCenter->id }}">
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
                    <select name="approver_user_id" id="approver_user_id" class="chosen-select form-control">
                        <option value="" disabled selected>Selecione uma opção </option>
                        @foreach ($approvers as $approver)
                            <option value="{{ $approver['id'] }}"
                                {{ $user['approver_user_id'] == $approver['id'] ? 'selected' : '' }}>
                                {{ $approver['person']['name'] }}
                            </option>
                        @endforeach
                    </select>
                @else
                    <select name="approver_user_id" id="approver_user_id" class="chosen-select form-control">
                        <option value="" disabled selected>Selecione uma opção </option>
                        @foreach ($approvers as $approver)
                            <option value="{{ $approver['id'] }}">
                                {{ $approver['person']['name'] }}
                            </option>
                        @endforeach
                    </select>
                @endif
            </div>
            {{-- LIMITE DE APROVAÇÃO --}}
            <div class="col-sm-2">
                <div class="form-group">
                    <label for="approve_limit" class="control-label">
                        Limite de Aprovação
                    </label>
                    @if (isset($user))
                        <div class="input-group">
                            <span class="input-group-addon">R$</span>
                            <input type="number" name="approve_limit" id="unit-price-currency"
                                placeholder="Ex: 100,00" class="form-control approve_limit" min="100"
                                max="500000" value="{{ $user['approve_limit'] }}" required>
                        </div>
                    @else
                        <div class="input-group">
                            <span class="input-group-addon">R$</span>
                            <input type="number" name="approve_limit" id="unit-price-currency"
                                placeholder="Ex: 100,00" class="form-control approve_limit" min="100"
                                max="500000" required>
                        </div>
                    @endif
                    <div class="no-limit"
                        style="
                            display: flex;
                            align-items: center;
                            gap: 5px;
                            margin-top: 3px;
                        ">
                        <input type="checkbox" id="checkbox-has-no-approve-limit"
                            class="checkbox-has-no-approve-limit" style="margin:0">
                        <label for="checkbox-has-no-approve-limit" style="margin:0; font-size: 11px;">
                            Sem limite de aprovação
                        </label>
                    </div>
                </div>
            </div>
        </div>
        {{-- CENTRO DE CUSTOS PERMITIDOS --}}
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <label for="approver_user_id" id="cost-center-permissions" class="control-label">Centros de
                        custos permitidos</label>
                    <select @if (!auth()->user()->profile->isAdmin) disabled @endif name="user_cost_center_permissions[]"
                        id="user_cost_center_permissions" multiple="multiple"
                        class="chosen-select form-control cost-centers-permissions"
                        placeholder="Selecione o(s) centro(s) de custo que este usuário possui permissão para compras">
                        @foreach ($costCenters as $costCenter)
                            <option value="{{ $costCenter->id }}" @if (isset($user) && collect($user->userCostCenterPermission)->contains('costCenter.id', $costCenter->id)) selected @endif>
                                {{ $costCenter->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="cost-center-options" style="width:70%">
                <div class="col-sm-2">
                    <a href="#cost-center-permissions" class="btn btn-small btn-primary btn-select-all-cost-centers"
                        style="font-size:12px; padding: 2.5px 12px">
                        Selecionar todos
                    </a>
                </div>
                <div class="col-sm-2">
                    <button type="button" class="btn btn-small btn-primary btn-clear-cost-centers"
                        style="font-size:12px; padding: 2.5px 12px">
                        Limpar
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- SALVAR/CANCELAR --}}
    <div class="form-actions pull-right">
        <button type="submit" class="btn btn-primary">Salvar</button>
        <a href="{{ route('users') }}" class="btn">Cancelar</a>
    </div>
    </form>
</div>
</div>


<script>
    $(() => {
        const $btnClearCostCenters = $('.btn-clear-cost-centers');
        const $btnSelectAllCostCenters = $('.btn-select-all-cost-centers');
        const $costCentersPermissions = $('.cost-centers-permissions');

        const $checkboxHasNoApproveLimit = $('.checkbox-has-no-approve-limit');
        const $approveLimit = $('.approve_limit');

        // centro de custo permissao
        //clear all
        $btnClearCostCenters.on('click', function() {
            $costCentersPermissions.val('');
            $costCentersPermissions.val('').trigger("chosen:updated");
        });

        // select all
        $btnSelectAllCostCenters.on('click', function() {
            $costCentersPermissions.find('option').each((_, option) => {
                $(option).prop('selected', true);
            }).closest('select').trigger('chosen:updated');
        });

        // checkbox sem limite aprovação
        $checkboxHasNoApproveLimit.on('click', function() {
            const isChecked = $(this).is(':checked');
            if (isChecked) {
                $(this).data('last-value', $approveLimit.val())
            }
            $approveLimit.prop('readonly', isChecked).val(isChecked ? null : $(this).data(
                'last-value'));
        });
    })
</script>
