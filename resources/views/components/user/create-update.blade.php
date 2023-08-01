@php
    $currentProfile = auth()->user()->profile->name
@endphp

<div class="box-title">
    <div class="row">
        <div class="col-md-6">
            <h3 style="color: white; margin-top: 5px">
                @if (isset($user))
                    Editar usuário
                @else
                    Novo usuário
                @endif
            </h3>
        </div>
        @if (isset($user) && auth()->user()->id !== $user->id)
            <div class="col-md-6 pull-right">
                <x-modalDelete />
                <button data-route="user" data-name="{{ $user->person->name }}" data-id="{{ $user->id }}" data-cy="btn-modal-excluir-usuario"
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
        <form method="POST" action="{{ route($action, $user->id) }}" class="form-validate" id="form-update" data-cy="form-update">
        @else
            <form method="POST" action="{{ route('register') }}" class="form-validate" id="form-register" data-cy="form-register">
    @endif
    @csrf

    {{-- DADOS PESSOAIS --}}
    <div class="personal-information">
        <h3>Dados Pessoais</h3>
        <div class="row">
            {{-- NOME --}}
            <div class="col-sm-3">
                <div class="form-group">
                    <label for="name" class="control-label required">Nome</label>
                    <input type="text" name="name" id="name" data-cy="name" placeholder="Nome Completo" class="form-control" @disabled($currentProfile !== 'admin')
                        data-rule-required="true" data-rule-minlength="2" 
                        @if (isset($user)) value="{{ $user->person->name }}" @endif>
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            {{-- DATA NASCIMENTO --}}
            <div class="col-sm-3">
                <div class="form-group">
                    <label for="birthdate" class="control-label">Data de nascimento</label>
                    <input type="date" name="birthdate" id="birthdate" data-cy="birthdate" class="form-control" @disabled($currentProfile !== 'admin') 
                        @if (isset($user)) value="{{ $user['person']['birthdate'] }}" @endif>
                </div>
            </div>
            {{-- DOCUMENTO --}}
            <div class="col-sm-3">
                <div class="form-group">
                    <label for="cpf_cnpj" class="control-label">Nº CPF/CNPJ</label>
                    <input type="text" name="cpf_cnpj" id="cpf_cnpj" data-cy="cpf_cnpj" data-rule-required="true" minlength="14" @disabled($currentProfile !== 'admin')
                        placeholder="Ex: 000.000.000-00" class="form-control cpf_cnpj"
                        @if (isset($user)) value="{{ $user->person->cpf_cnpj }}" @endif>
                    @error('cpf_cnpj')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            {{-- PHONE --}}
            <div class="col-sm-3">
                <div class="form-group">
                    <label for="number" class="control-label">
                        Telefone/Celular
                    </label>
                    <input type="text" name="number" id="number" data-cy="number" placeholder="Ex: (00) 0000-0000" @disabled($currentProfile !== 'admin')
                        class="form-control phone_number" data-rule-required="true" minlength="14"
                        @if (isset($user)) value="{{ $user->person->phone->number }}" @endif>
                    @error('number')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                    <div style="margin: 5px 0px -10px 0px;">
                        {{-- PESSOAL --}}
                        <input @disabled($currentProfile !== 'admin') @checked(isset($user) && $user->person->phone->phone_type === 'personal')
                            class="icheck-me" type="radio" name="phone_type" id="personal" data-cy="personal" value="personal" data-skin="minimal">
                        <label class="form-check-label" for="personal">Pessoal</label>
                        {{-- COMERCIAL --}}
                        <input @disabled($currentProfile !== 'admin') @checked(isset($user) && $user->person->phone->phone_type === 'commercial')
                            class="icheck-me" type="radio" name="phone_type" id="commercial" data-cy="commercial" value="commercial" data-skin="minimal"
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
                    <label for="email" class="control-label">E-mail</label>
                    <input type="email" name="email" id="email" data-cy="email" placeholder="user_email@essentia.com.br" @disabled($currentProfile !== 'admin')
                        @if (isset($user)) value="{{ $user->email }}" @endif class="form-control @error('email') is-invalid @enderror" data-rule-required="true" data-rule-email="true">
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            {{-- SENHA --}}
            <div class="col-sm-3">
                <div class="form-group">
                    <label for="password" class="control-label">Senha</label>
                    <input type="password" name="password" id="password" data-cy="password"
                        placeholder="Deve conter ao menos 8 digitos"
                        @if (!isset($user)) required
                            data-rule-required="true"
                            data-rule-minlength="8"
                            class="form-control @error('password') is-invalid @enderror"
                        @else
                            class="form-control @error('password') is-invalid @enderror" @endif
                        autocomplete="new-password">
                    @error('password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            {{-- CONFIRMAR SENHA --}}
            <div class="col-sm-3">
                <div class="form-group">
                    <label for="password-confirm" class="control-label">Confirmar
                        Senha</label>
                    <input type="password" name="password_confirmation" id="password-confirm" data-cy="password-confirm" placeholder="Digite novamente a senha"
                        autocomplete="new-password"
                        @if (!isset($user)) class="form-control"
                            data-rule-required="true"
                        @else 
                            class="form-control no-validation" 
                        @endif >
                    @error('password_confirmation')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
      
        @if ($currentProfile === 'admin')
            <div class="row" style="padding: 25px 0">
                {{-- PERFIL DE USUÁRIO --}}
                <div class="col-sm-4">
                    <label for="form-check" style="margin-bottom: 12px;">Perfil de Usuário</label>
                    <div class="form-check">
                        {{-- ADMIN --}}
                        <input @checked(isset($user) && $user->profile->name === 'admin') class="icheck-me"
                            type="radio" name="profile_type" id="profile_admin" data-cy="profile_admin" value="admin" data-skin="minimal">
                        <label class="form-check-label" for="profile_admin">Administrador</label>

                        {{-- PADRÃO --}}
                        <input @checked(isset($user) && $user->profile->name === 'normal') class="icheck-me"
                            type="radio" name="profile_type" id="profile_normal" data-cy="profile_normal" value="normal" data-skin="minimal"
                            @if (!isset($user)) checked @endif>
                        <label class="form-check-label" for="personal">Padrão</label>

                        <input @checked(isset($user) && $user->profile->name === 'suprimentos_hkm') class="icheck-me"
                            type="radio" name="profile_type" id="profile_suprimentos_hkm" data-cy="profile_suprimentos_hkm" value="suprimentos_hkm" data-skin="minimal">
                        <label class="form-check-label" for="personal">Suprimentos HKM</label>

                        <input @checked(isset($user) && $user->profile->name === 'suprimentos_inp') class="icheck-me"
                            type="radio" name="profile_type" id="profile_suprimentos_inp" data-cy="profile_suprimentos_inp" value="suprimentos_inp" data-skin="minimal" >
                        <label class="form-check-label" for="personal">Suprimentos INP</label>

                        @error('approve_limit')
                            <p><strong>{{ $message }}</strong></p>
                        @enderror
                    </div>
                </div>
                <div class="col-sm-4">
                    <label for="form-check" style="margin-bottom: 12px;">Autorização para Solicitar</label>
                    <div class="form-check">
                        <input @checked(!isset($user) || (isset($user) && $user->is_buyer)) name="is_buyer" id="is_buyer_true" data-cy="is_buyer_true"
                             class="icheck-me" type="radio" value="1" data-skin="minimal">
                        <label class="form-check-label" for="is_buyer_true">Autorizado</label>

                        <input @checked(isset($user) && !$user->is_buyer) class="icheck-me" type="radio" name="is_buyer" id="is_buyer_false" 
                            data-cy="is_buyer_false" value="0" data-skin="minimal" >
                        <label class="form-check-label" for="is_buyer_false">Não autorizado</label>

                        @error('is_buyer')
                            <p><strong>{{ $message }}</strong></p>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="cost_center_id" class="control-label">Setor</label>
                        @if (isset($user))
                            <select name="cost_center_id" id="cost_center_id" data-cy="cost_center_id"
                                class='chosen-select form-control @error('cost_center_id') is-invalid @enderror'
                                data-rule-required="true" required>
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
                            <select name="cost_center_id" id="cost_center_id" data-cy="cost_center_id" class='chosen-select form-control'
                                data-rule-required="true">
                                <option value="" disabled selected>Selecione uma opção </option>
                                @foreach ($costCenters as $costCenter)
                                    <option value="{{ $costCenter->id }}">
                                        {{ $costCenter->name }}
                                    </option>
                                @endforeach
                            </select>
                        @endif
                    </div>
                </div>
                {{-- USUÁRIO APROVADOR --}}
                <div class="col-sm-3">
                    <label for="approver_user_id" class="control-label">Usuário aprovador</label>
                    @if (isset($user))
                        <select name="approver_user_id" id="approver_user_id" data-cy="approver_user_id" class="chosen-select form-control">
                            <option value="" disabled selected>Selecione uma opção </option>
                            @foreach ($approvers as $approver)
                                <option value="{{ $approver->id }}" @selected($user->approver_user_id == $approver->id)>
                                    {{ $approver->person->name }}
                                </option>
                            @endforeach
                        </select>
                    @else
                        <select name="approver_user_id" id="approver_user_id" data-cy="approver_user_id" class="chosen-select form-control">
                            <option value="" disabled selected>Selecione uma opção </option>
                            @foreach ($approvers as $approver)
                                <option value="{{ $approver->id }}">
                                    {{ $approver->person->name }}
                                </option>
                            @endforeach
                        </select>
                    @endif
                </div>
                {{-- LIMITE DE APROVAÇÃO --}}
                <div class="col-sm-2">
                    <div class="form-group">
                        <label for="format-approve-limit" class="control-label">
                            Limite de Aprovação
                        </label>
                        @if (isset($user))
                            <div class="input-group">
                                <span class="input-group-addon">R$</span>
                                <input type="text" id="format-approve-limit" data-cy="format-approve-limit" placeholder="Ex: 100,00" class="form-control format-approve-limit" data-rule-required="true"
                                    @if ($user->approve_limit === null) readonly @else value="{{ (float) $user->approve_limit }}" @endif>
                                <input type="hidden" name="approve_limit" id="approve_limit" data-cy="approve_limit" class="approve_limit no-validation">
                            </div>
                        @else
                            <div class="input-group">
                                <span class="input-group-addon">R$</span>
                                <input type="text" id="format-approve-limit" data-cy="format-approve-limit" placeholder="Ex: 100,00" class="form-control format-approve-limit" data-rule-required="true">
                                <input type="hidden" name="approve_limit" id="approve_limit" data-cy="approve_limit" class="approve_limit no-validation">
                            </div>
                        @endif
                        <div class="no-limit"
                            style="
                                display: flex;
                                align-items: center;
                                gap: 5px;
                                margin-top: 3px;
                            ">
                            <input type="checkbox" id="checkbox-has-no-approve-limit" data-cy="checkbox-has-no-approve-limit" class="checkbox-has-no-approve-limit" style="margin:0"
                                @checked(isset($user) && $user->approve_limit === null)>
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
                        <label for="approver_user_id" id="cost-center-permissions" class="control-label">Centros de custos permitidos</label>
                        <select @disabled(!$currentProfile === 'admin') name="user_cost_center_permissions[]" id="user_cost_center_permissions" data-cy="user_cost_center_permissions" multiple="multiple"
                            class="chosen-select form-control cost-centers-permissions" placeholder="Selecione o(s) centro(s) de custo que este usuário possui permissão para compras">
                            @foreach ($costCenters as $costCenter)
                                @php
                                    $companyName = $costCenter->company->name;
                                    $costCenterName = $costCenter->name;
                                @endphp 

                                <option value="{{ $costCenter->id }}" @selected(isset($user) && collect($user->userCostCenterPermission)->contains('costCenter.id', $costCenter->id))>
                                    {{ $companyName . ' / ' . $costCenterName }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-12 cost-center-options">
                    <div class="row">
                        <div class="col-sm-2">
                            <a href="#cost-center-permissions" class="btn btn-small btn-primary btn-select-all-cost-centers" data-cy="btn-select-all-cost-centers"
                                style="font-size:12px;">
                                Selecionar todos
                            </a>
                            <button type="button" class="btn btn-small btn-primary btn-clear-cost-centers" data-cy="btn-clear-cost-centers"
                                style="font-size:12px;">
                                Limpar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    {{-- SALVAR/CANCELAR --}}
    <div class="form-actions pull-right">
        <button type="submit" class="btn btn-primary" data-cy="btn-submit-salvar">Salvar</button>
        <a href="{{ route('users') }}" class="btn" data-cy="btn-cancelar">Cancelar</a>
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
        const $approveLimit = $('.format-approve-limit');
        const $hiddenApproveLimit = $('.approve_limit');
        const $identificationDocument = $('.cpf_cnpj');
        const $phoneNumber = $('.phone_number');

        // centro de custo permissao
        // clear all
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
            $approveLimit.data('rule-required', !isChecked);
            $approveLimit.valid();
            if (isChecked) {
                $(this).data('last-value', $approveLimit.val());
                $(this).closest('.form-group').removeClass('has-error');
            }
            const currentValue = isChecked ? null : $(this).data('last-value');
            $approveLimit.prop('readonly', isChecked).val(currentValue).valid();
            $hiddenApproveLimit.val(currentValue);
        });

        // masks
        $identificationDocument.imask({
            mask: [{
                    mask: '000.000.000-00',
                },
                {
                    mask: '00.000.000/0000-00',
                }
            ],
            minLength: 13
        });
        $phoneNumber.imask({
            mask: [{
                    mask: '(00) 0000-0000'
                },
                {
                    mask: '(00) 00000-0000'
                }
            ]
        });
        $approveLimit.imask({
            mask: Number,
            scale: 2,
            thousandsSeparator: '.',
            normalizeZeros: true,
            padFractionalZeros: true,
            min: 100,
            max: 500000,
        });

        // approve_limit input hidden
        $approveLimit.on('input', function() {
            const formattedValue = $(this).val();
            if (formattedValue !== null) {
                const processedValue = formattedValue.replace(/[^0-9,]/g, '').replace(/,/g, '.');
                const rawValue = parseFloat(processedValue);
                $('.approve_limit').val(rawValue.toFixed(2));
            }
        });
    })
</script>
