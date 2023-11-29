@php
    use Illuminate\Support\Facades\Gate;

    $isAdmin = Gate::allows('admin');
    $isGestorUsuarios = Gate::allows('gestor_usuarios');
    $isOwnRequest = isset($user) && auth()->user()->id === $user->id;
    $isDisabled = !$isAdmin && (!$isGestorUsuarios || ($isGestorUsuarios && $isOwnRequest));
@endphp

<div class="main-container">
    <div class="row" style="margin: 0 0 30px">
        <div class="col-md-6" style="padding: 0">
            <h1 class="page-title">{{ isset($user) ? 'Editar usuário' : 'Novo usuário' }}</h1>
        </div>
        @if (isset($user) && auth()->user()->id !== $user->id)
            <div class="col-md-6" style="padding: 0">
                <x-modals.delete />
                <button data-route="user" data-name="{{ $user->person->name }}" data-id="{{ $user->id }}" data-cy="btn-modal-excluir-usuario" data-bs-toggle="modal"
                    data-bs-target="#modal-delete" rel="tooltip" title="Excluir" class="btn btn-primary btn-small btn-danger pull-right">
                    Excluir usuário
                </button>
            </div>
        @endif
    </div>

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
                    <label for="name" class="required regular-text">Nome</label>
                    <input type="text" name="name" id="name" data-cy="name" placeholder="Nome Completo" class="form-control" @disabled($isDisabled)
                        data-rule-required="true" data-rule-minlength="2" value="{{ old('name', isset($user) ? $user->person->name : '') }}">
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            {{-- DATA NASCIMENTO --}}
            <div class="col-sm-3">
                <div class="form-group">
                    <label for="birthdate" class="regular-text">Data de nascimento</label>
                    <input type="date" name="birthdate" id="birthdate" data-cy="birthdate" class="form-control" @disabled($isDisabled)
                        value="{{ old('birthdate', isset($user) ? $user['person']['birthdate'] : '') }}">
                </div>
            </div>
            {{-- DOCUMENTO --}}
            <div class="col-sm-3">
                <div class="form-group">
                    <label for="cpf_cnpj" class="regular-text">Nº CPF/CNPJ</label>
                    <input type="text" name="cpf_cnpj" id="cpf_cnpj" data-cy="cpf_cnpj" data-rule-required="true" minlength="14" @disabled($isDisabled)
                        placeholder="Ex: 000.000.000-00" class="form-control cpf_cnpj" value="{{ old('cpf_cnpj', isset($user) ? $user->person->cpf_cnpj : '') }}">
                    @error('cpf_cnpj')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            {{-- PHONE --}}
            <div class="col-sm-3">
                <div class="form-group">
                    <label for="number" class="regular-text"> Telefone/Celular </label>
                    <input type="text" name="number" id="number" data-cy="number" placeholder="Ex: (00) 0000-0000" @disabled($isDisabled)
                        class="form-control phone_number" data-rule-required="true" minlength="14" value="{{ old('number', isset($user) ? $user->person->phone?->number : '') }}">
                    @error('number')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror

                    <div style="margin-top: 10px">
                        {{-- PESSOAL --}}
                        <label class="form-check-label regular-text" for="personal">
                            <input @disabled($isDisabled) @checked(isset($user) && $user->person->phone?->phone_type === 'personal') type="radio" name="phone_type" id="personal" data-cy="personal" value="personal"
                                data-skin="minimal">
                            Pessoal
                        </label>

                        {{-- COMERCIAL --}}
                        <label class="form-check-label regular-text" for="commercial">
                            <input @disabled($isDisabled) @checked(isset($user) && $user->person->phone?->phone_type === 'commercial') type="radio" name="phone_type" id="commercial" data-cy="commercial"
                                value="commercial" data-skin="minimal" @if (!isset($user)) checked @endif>
                            Comercial
                        </label>
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
                    <label for="email" class="regular-text">E-mail</label>
                    <input type="email" name="email" id="email" data-cy="email" placeholder="user_email@essentia.com.br" @disabled($isDisabled)
                        data-rule-required="true" data-rule-email="true" value="{{ old('email', isset($user) ? $user->email : '') }}"
                        class="form-control @error('email') is-invalid @enderror">
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            {{-- SENHA --}}
            <div class="col-sm-3">
                <div class="form-group">
                    <label for="password" class="regular-text">Senha</label>
                    <input type="password" name="password" id="password" data-cy="password" placeholder="Deve conter ao menos 8 digitos"
                        @if (!isset($user)) required data-rule-required="true" data-rule-minlength="8" class="form-control @error('password') is-invalid @enderror"
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
                    <label for="password-confirm" class="regular-text">Confirmar senha</label>
                    <input type="password" name="password_confirmation" id="password-confirm" data-cy="password-confirm" placeholder="Digite novamente a senha"
                        autocomplete="new-password"
                        @if (!isset($user)) class="form-control" data-rule-required="true"
                        @else
                            class="form-control no-validation" @endif>
                    @error('password_confirmation')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

        </div>

        @if (!$isDisabled)
            <div class="row" style="padding: 25px 0">
                {{-- PERFIL DE USUÁRIO --}}
                <div class="form-group">
                    <div class="col-sm-12 my-3 fs-6">
                        <label for="form-check" style="display:block; margin-bottom: 12px;" class="regular-text fs-5">Perfil de usuário</label>
                        @if ($isAdmin)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="profile_type" id="profile_admin" data-cy="profile_admin" value="admin"
                                    @checked(isset($user) && $user->profile->name === 'admin')>
                                <label class="form-check-label" for="profile_admin"> Administrador </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="profile_type" id="profile_diretor" data-cy="profile_diretor" value="diretor"
                                    @checked(isset($user) && $user->profile->name === 'diretor')>
                                <label class="form-check-label" for="profile_diretor"> Diretor </label>
                            </div>
                        @endif
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="profile_type" id="profile_normal" data-cy="profile_normal" value="normal"
                                @checked(isset($user) && $user->profile->name === 'normal')>
                            <label class="form-check-label" for="profile_normal"> Padrão </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="profile_type" id="profile_suprimentos_hkm" data-cy="profile_suprimentos_hkm"
                                value="suprimentos_hkm" @checked(isset($user) && $user->profile->name === 'suprimentos_hkm')>
                            <label class="form-check-label" for="profile_suprimentos_hkm"> Suprimentos HKM </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="profile_type" id="profile_suprimentos_inp" data-cy="profile_suprimentos_inp"
                                value="suprimentos_inp" @checked(isset($user) && $user->profile->name === 'suprimentos_inp')>
                            <label class="form-check-label" for="profile_suprimentos_inp"> Suprimentos INP </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="profile_type" id="gestor_usuarios" data-cy="gestor_usuarios" value="gestor_usuarios"
                                @checked(isset($user) && $user->profile->name === 'gestor_usuarios')>
                            <label class="form-check-label" for="gestor_usuarios"> Gestor de usuários </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="profile_type" id="gestor_fornecedores" data-cy="gestor_fornecedores"
                                value="gestor_fornecedores" @checked(isset($user) && $user->profile->name === 'gestor_fornecedores')>
                            <label class="form-check-label" for="gestor_fornecedores"> Gestor de fornecedores </label>
                        </div>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label for="form-check" style="margin-bottom: 12px;" class="regular-text">Autorização para solicitar</label>
                        <div class="form-check row">
                            <div class="col-md-12">
                                <div>
                                    <input @checked(!isset($user) || (isset($user) && $user->is_buyer)) name="is_buyer" id="is_buyer_true" data-cy="is_buyer_true" type="radio" value="1"
                                        data-skin="minimal">
                                    <label class="form-check-label secondary-text" for="is_buyer_true">Autorizado</label>
                                </div>
                                <div>
                                    <input @checked(isset($user) && !$user->is_buyer) type="radio" name="is_buyer" id="is_buyer_false" data-cy="is_buyer_false" value="0"
                                        data-skin="minimal">
                                    <label class="form-check-label secondary-text" for="is_buyer_false">Não autorizado</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="form-check" style="margin-bottom: 12px;" class="regular-text">Este usuário pode solicitar para outras pessoas?</label>
                        <fieldset data-rule-required="true">
                            <div class="row">
                                <div class="col-sm-12">
                                    <input @checked(isset($user) && $user?->can_associate_requester) name="can_associate_requester" id="can-associate-requester" data-cy="can-associate-requester"
                                        type="radio" value="1" data-skin="minimal" required>
                                    <label class="form-check-label secondary-text" for="can-associate-requester">Sim</label>
                                    <input @checked(isset($user) && !$user?->can_associate_requester) type="radio" name="can_associate_requester" id="can-not-associate-requester"
                                        data-cy="can-not-associate-requester" value="0" data-skin="minimal" required>
                                    <label class="form-check-label secondary-text" for="can-not-associate-requester">Não</label>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="cost_center_id" class="regular-text">Setor</label>
                        @if (isset($user))
                            <select name="cost_center_id" id="cost_center_id" data-cy="cost_center_id" class='select2-me @error('cost_center_id') is-invalid @enderror'
                                style="width: 100%" data-rule-required="true" required data-placeholder="Selecione uma opção">
                                <option value=""></option>
                                @foreach ($costCenters as $costCenter)
                                    @php
                                        $companyName = $costCenter->company->name;
                                        $costCenterName = $costCenter->name;
                                        $formattedCnpj = preg_replace('/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/', '$1.$2.$3/$4-$5', $costCenter->company->cnpj);
                                    @endphp
                                    <option value="{{ $costCenter->id }}" @selected(isset($user->person->costCenter) && $user->person->costCenter->id === $costCenter->id)>
                                        {{ $formattedCnpj . ' - ' . $companyName . ' / ' . $costCenterName }}
                                    </option>
                                @endforeach
                            </select>
                            @error('cost_center_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        @else
                            <select name="cost_center_id" id="cost_center_id" data-cy="cost_center_id" class='select2-me' style="width: 100%" data-rule-required="true"
                                data-placeholder="Selecione uma opção">
                                <option value=""></option>
                                @foreach ($costCenters as $costCenter)
                                    @php
                                        $companyName = $costCenter->company->name;
                                        $costCenterName = $costCenter->name;
                                        $formattedCnpj = preg_replace('/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/', '$1.$2.$3/$4-$5', $costCenter->company->cnpj);
                                        $isSelected = old('cost_center_id') == $costCenter->id;
                                    @endphp
                                    <option value="{{ $costCenter->id }}" @selected($isSelected)>
                                        {{ $formattedCnpj . ' - ' . $companyName . ' / ' . $costCenterName }}
                                    </option>
                                @endforeach
                            </select>
                        @endif
                    </div>
                </div>
                {{-- USUÁRIO APROVADOR --}}
                <div class="col-sm-3">
                    <label for="approver_user_id" class="regular-text">Usuário aprovador</label>
                    @if (isset($user))
                        <select name="approver_user_id" id="approver_user_id" data-cy="approver_user_id" class="select2-me" style="width: 100%"
                            data-placeholder="Selecione uma opção">
                            <option value=""></option>
                            @foreach ($approvers as $approver)
                                <option value="{{ $approver->id }}" @selected($user->approver_user_id == $approver->id)>
                                    {{ $approver->person->name }}
                                </option>
                            @endforeach
                        </select>
                    @else
                        <select name="approver_user_id" id="approver_user_id" data-cy="approver_user_id" class="select2-me" style="width: 100%"
                            data-placeholder="Selecione uma opção">
                            <option value=""></option>
                            @foreach ($approvers as $approver)
                                @php
                                    $isSelected = old('approver_user_id') == $approver->id;
                                @endphp
                                <option value="{{ $approver->id }}" @selected($isSelected)>
                                    {{ $approver->person->name }}
                                </option>
                            @endforeach
                        </select>
                    @endif
                </div>
                {{-- LIMITE DE APROVAÇÃO --}}
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="format-approve-limit" class="regular-text"> Limite de aprovação </label>
                        @if (isset($user))
                            <div class="input-group">
                                <span class="input-group-text">R$</span>
                                <input type="text" id="format-approve-limit" data-cy="format-approve-limit" placeholder="Ex: 100,00"
                                    class="form-control format-approve-limit"
                                    @if ($user->approve_limit === null) readonly
                                @else
                                    data-rule-required="true"
                                    value="{{ (float) $user->approve_limit }}" @endif>

                                <input type="hidden" name="approve_limit" id="approve_limit" data-cy="approve_limit" class="approve_limit no-validation">
                            </div>
                        @else
                            <div class="input-group">
                                <span class="input-group-text">R$</span>
                                <input type="text" id="format-approve-limit" data-cy="format-approve-limit" placeholder="Ex: 100,00"
                                    class="form-control format-approve-limit" data-rule-required="true" value="{{ old('approve_limit') }}">
                                <input type="hidden" name="approve_limit" id="approve_limit" data-cy="approve_limit" class="approve_limit no-validation"
                                    value="{{ old('approve_limit') }}">
                            </div>
                        @endif
                        <div class="no-limit"
                            style="
                                display: flex;
                                align-items: center;
                                gap: 5px;
                                margin-top: 3px;
                            ">
                            <input type="checkbox" id="checkbox-has-no-approve-limit" data-cy="checkbox-has-no-approve-limit" class="checkbox-has-no-approve-limit"
                                style="margin:0" @checked((isset($user) && $user->approve_limit === null) || old('checkbox-has-no-approve-limit'))>
                            <label for="checkbox-has-no-approve-limit" style="margin:0;" class="secondary-text"> Sem limite de aprovação </label>
                        </div>
                    </div>
                </div>
            </div>
            {{-- CENTRO DE CUSTOS PERMITIDOS --}}
            <div class="row">
                <div class="col-sm-9">
                    <div class="form-group">
                        <label for="approver_user_id" id="cost-center-permissions" class="regular-text">Centros de custos permitidos</label>
                        <select @disabled(!$isAdmin) name="user_cost_center_permissions[]" id="user_cost_center_permissions" data-cy="user_cost_center_permissions"
                            multiple="multiple" class="select2-me cost-centers-permissions" style="width: 100%"
                            data-placeholder="Selecione o(s) centro(s) de custo que este usuário possui permissão para compras" required data-rule-required="true">
                            @foreach ($costCenters as $costCenter)
                                @php
                                    $companyName = $costCenter->company->name;
                                    $costCenterName = $costCenter->name;
                                @endphp

                                <option value="{{ $costCenter->id }}"
                                    @if (old('user_cost_center_permissions') !== null) {{ in_array($costCenter->id, old('user_cost_center_permissions')) ? 'selected' : '' }}
                                    @elseif (isset($user) && collect($user->userCostCenterPermission)->contains('costCenter.id', $costCenter->id))
                                        selected @endif>
                                    {{ $companyName . ' / ' . $costCenterName }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-9">
                    <a href="#cost-center-permissions" class="btn btn-secondary btn-small btn-select-all-cost-centers" data-cy="btn-select-all-cost-centers">
                        Selecionar todos
                    </a>
                    <button type="button" class="btn btn-secondary btn-small btn-clear-cost-centers" data-cy="btn-clear-cost-centers">
                        Limpar
                    </button>
                </div>
            </div>
        @endif

        <div class="pull-right">
            <button type="submit" class="btn btn-primary btn-large" data-cy="btn-submit-salvar">Salvar</button>
        </div>

    </div>

    </form>
</div>

@push('scripts')
    <script type="module">
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
                $costCentersPermissions.val('').trigger("change");
            });

            // select all
            $btnSelectAllCostCenters.on('click', function() {
                $costCentersPermissions.val($('.cost-centers-permissions option').map((_, option) => $(option).val())).trigger('change');
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
            $approveLimit.on('input blur', function() {
                const formattedValue = $(this).val();
                if (formattedValue !== null) {
                    const processedValue = formattedValue.replace(/[^0-9,]/g, '').replace(/,/g, '.');
                    const rawValue = parseFloat(processedValue);
                    $('.approve_limit').val(rawValue.toFixed(2));
                }
            });
        })
    </script>
@endpush
