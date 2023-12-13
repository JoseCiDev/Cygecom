@php
    use Illuminate\Support\Facades\Gate;
    use App\Enums\CompanyGroup;

    $isAdmin = Gate::allows('admin');
    $isGestorUsuarios = Gate::allows('gestor_usuarios');
    $isOwnRequest = isset($user) && auth()->user()->id === $user->id;
    $isDisabled = !$isAdmin && (!$isGestorUsuarios || ($isGestorUsuarios && $isOwnRequest));

    $action = isset($user) ? 'users.update' : 'register';
    $route = isset($user) ? route($action, $user->id) : route('users.store');
    $formId = isset($user) ? 'form-update' : 'form-register';
    $userProfile = isset($user) ? $user->profile->name : null;
    $isBuyer = isset($user) ? $user->is_buyer : null;
@endphp

<x-app>
    @push('styles')
        <style>
            .select2-container--default .select2-selection--multiple .select2-selection__rendered {
                overflow-y: scroll;
            }

            .user-header {
                display: flex;
                flex-direction: column;
                gap: 10px;
                justify-content: space-between;
            }

            .user-header .options {
                display: flex;
                flex-wrap: wrap;
                gap: 5px;
            }

            .user-header .options>* {
                min-width: fit-content;
                flex: 1 0 auto;
            }

            .form-user {
                display: flex;
                flex-direction: column;
                padding: 20px 0;
            }

            .form-user #submit {
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 5px;
            }

            .form-user #submit .spinner-border {
                width: 20px;
                height: 20px;
                display: none;
            }

            .form-user .personal-data,
            .form-user .user-data,
            .form-user .advanced-user-data {
                display: flex;
                flex-direction: row;
                flex-wrap: wrap;
                gap: 15px;
                padding-bottom: 30px;
            }

            .form-user .personal-data>* {
                flex: 1 0 45%;
                min-width: 270px;
            }

            .form-user .personal-data .phone-type-box {
                display: flex;
                gap: 15px;
            }

            .form-user .user-data>* {
                flex-grow: 1;
                min-width: 265px;
            }

            .form-user .advanced-user-data {
                display: flex;
                flex-direction: column;
            }

            .form-user .advanced-user-data .advanced-user-selects {
                display: flex;
                flex-direction: column;
                gap: 15px;
                width: 100%;
            }

            .form-user .advanced-user-data .request-auth-checkbox {
                display: flex;
                flex-wrap: wrap;
                column-gap: 15px;
            }

            .form-user .advanced-user-data .advanced-user-data-auth {
                display: flex;
                flex-wrap: wrap;
                row-gap: 15px;
                column-gap: 30px;
                width: 100%;
            }

            .form-user .advanced-user-data .cost-center-permissions-box {
                display: flex;
                flex-direction: column;
                width: 100%;
            }

            .form-user .advanced-user-data .cost-center-permissions-box .cost-center-box-btns {
                display: flex;
                flex-direction: row;
                flex-wrap: wrap;
                justify-content: flex-end;
                gap: 5px;
                margin: 10px 0;
            }

            .form-user .advanced-user-data .cost-center-permissions-box .cost-center-box-btns>* {
                flex-grow: 1;
                flex-basis: 250px;
            }

            @media(min-width: 768px) {
                .form-user .advanced-user-data .advanced-user-selects {
                    flex-direction: row;
                    flex-wrap: wrap;
                }

                .form-user .advanced-user-data .advanced-user-selects>* {
                    flex: 1 0 45%;
                }

                .form-user #submit {
                    align-self: flex-end;
                }

                .user-header .options>* {
                    flex-grow: 0;
                }

            }

            @media(min-width: 1024px) {

                .form-user .advanced-user-data .cost-center-permissions-box .cost-center-box-btns .btn-clear-cost-centers,
                .form-user .advanced-user-data .cost-center-permissions-box .cost-center-box-btns .clear-supplies-cost-centers {
                    flex: 0;
                }

                .user-header {
                    flex-direction: row;
                }

                .user-header .options {
                    justify-content: flex-end;
                }
            }

            @media(min-width: 1280px) {
                .form-user .personal-data>* {
                    flex: 1 0 20%;
                    min-width: none;
                }

                .form-user .advanced-user-data .advanced-user-selects>* {
                    flex: 1 0 20%;
                }
            }
        </style>
    @endpush

    <x-modals.edit-user-ability :abilities="$abilities" />
    <x-modals.delete />
    <x-toast />

    <div class="user-header">
        <h1 class="page-title">{{ isset($user) ? 'Editar usuário' : 'Novo usuário' }}</h1>

        @if (isset($user))
            <div class="options">
                @can('get.users.show')
                    <a href="{{ route('users.show', ['user' => $user]) }}" class="btn btn-small btn-secondary">
                        <i class="fa-solid fa-eye"></i>
                        Ver todas habilidades
                    </a>
                @endcan

                @can('get.user.show.json', 'post.user.abilities.store')
                    <button class="btn btn-mini btn-secondary" data-bs-toggle="modal" data-bs-target="#modal-edit-user-ability" data-user-id={{ $user->id }}>
                        <i class="fa-solid fa-sliders"></i>
                        Editar habilidades
                    </button>
                @endcan

                @if (auth()->user()->id !== $user->id)
                    <button data-route="users.destroy" data-name="{{ $user->person->name }}" data-id="{{ $user->id }}" data-cy="btn-modal-excluir-usuario"
                        data-bs-toggle="modal" data-bs-target="#modal-delete" rel="tooltip" title="Excluir" class="btn btn-primary btn-small btn-danger pull-right">
                        Excluir usuário
                    </button>
                @endif
            </div>
        @endif
    </div>

    <form method="POST" action="{{ $route }}" class="form-validate form-user" id="{{ $formId }}" data-cy="{{ $formId }}">
        @csrf

        <h4>Dados de Usuário</h4>
        <div class="personal-data">

            {{-- NOME --}}
            <div class="form-group">
                <label for="name" class="required regular-text">Nome</label>
                <input type="text" name="name" id="name" data-cy="name" placeholder="Nome completo" class="form-control" @disabled($isDisabled)
                    data-rule-required="true" data-rule-minlength="2" value="{{ old('name', isset($user) ? $user->person->name : '') }}">
                @error('name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            {{-- DATA NASCIMENTO --}}
            <div class="form-group">
                <label for="birthdate" class="regular-text">Data de nascimento</label>
                <input type="date" name="birthdate" id="birthdate" data-cy="birthdate" class="form-control" @disabled($isDisabled)
                    value="{{ old('birthdate', isset($user) ? $user['person']['birthdate'] : '') }}">
            </div>

            {{-- DOCUMENTO --}}
            <div class="form-group">
                <label for="cpf_cnpj" class="regular-text">Nº CPF/CNPJ</label>
                <input type="text" name="cpf_cnpj" id="cpf_cnpj" data-cy="cpf_cnpj" data-rule-required="true" minlength="14" @disabled($isDisabled)
                    placeholder="Ex: 000.000.000-00" class="form-control cpf_cnpj" value="{{ old('cpf_cnpj', isset($user) ? $user->person->cpf_cnpj : '') }}">
                @error('cpf_cnpj')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            {{-- PHONE --}}
            <div class="form-group">
                <label for="number" class="regular-text"> Telefone/Celular </label>
                <input type="text" name="number" id="number" data-cy="number" placeholder="Ex: (00) 0000-0000" @disabled($isDisabled) class="form-control phone_number"
                    data-rule-required="true" minlength="14" value="{{ old('number', isset($user) ? $user->person->phone?->number : '') }}">
                @error('number')
                    <span class="text-danger">{{ $message }}</span>
                @enderror

                <div class="phone-type-box">
                    <div class="form-check">
                        <input class="form-check-input" @disabled($isDisabled) @checked(isset($user) && $user->person->phone?->phone_type === 'personal') type="radio" name="phone_type" id="personal" data-cy="personal"
                            value="personal" data-skin="minimal">
                        <label class="form-check-label" for="personal"> Pessoal </label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" @disabled($isDisabled) @checked(isset($user) && $user->person->phone?->phone_type === 'commercial') type="radio" name="phone_type" id="commercial"
                            data-cy="commercial" value="commercial" data-skin="minimal" @if (!isset($user)) checked @endif>
                        <label class="form-check-label" for="commercial"> Comercial </label>
                    </div>
                </div>

                @error('phone_type')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <h4>Dados de usuário</h4>
        <div class="user-data">

            {{-- E-MAIL --}}
            <div class="form-group">
                <label for="email" class="regular-text">E-mail</label>
                <input type="email" name="email" id="email" data-cy="email" placeholder="user_email@essentia.com.br" @disabled($isDisabled)
                    data-rule-required="true" data-rule-email="true" value="{{ old('email', isset($user) ? $user->email : '') }}"
                    class="form-control @error('email') is-invalid @enderror">
                @error('email')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            {{-- SENHA --}}
            <div class="form-group">
                <label for="password" class="regular-text">Senha</label>
                <input type="password" name="password" id="password" data-cy="password" placeholder="Deve conter ao menos 8 dígitos"
                    @if (!isset($user)) required data-rule-required="true" data-rule-minlength="8" class="form-control @error('password') is-invalid @enderror"
            @else
                class="form-control @error('password') is-invalid @enderror" @endif
                    autocomplete="new-password">
                @error('password')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            {{-- CONFIRMAR SENHA --}}
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

        @if (Gate::any(['admin', 'gestor_usuarios']))
            <h4>Dados avançados de usuário</h4>
            <div class="advanced-user-data">

                <div class="advanced-user-selects">
                    <div class="form-group profile-type-box">
                        <label for="profile_type" class="regular-text">Perfil</label>
                        <select name="profile_type" id="profile_type" data-cy="profile_type" class='select2-me' data-rule-required="true" style="width: 100%"
                            data-placeholder="Selecione uma perfil">
                            <option value=""></option>
                            @foreach ($profiles as $profile)
                                @php
                                    $isSelected = $userProfile === $profile->name;
                                @endphp
                                <option value="{{ $profile->name }}" @selected($isSelected)>{{ $profile->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group user-cost-center-box">
                        <label for="cost_center_id" class="regular-text">Setor</label>
                        <select name="cost_center_id" id="cost_center_id" data-cy="cost_center_id" class='select2-me' data-rule-required="true" style="width: 100%"
                            data-placeholder="Selecione uma setor">
                            <option value=""></option>
                            @foreach ($costCenters as $costCenter)
                                @php
                                    $companyName = $costCenter->company->name;
                                    $costCenterName = $costCenter->name;
                                    $formattedCnpj = preg_replace('/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/', '$1.$2.$3/$4-$5', $costCenter->company->cnpj);
                                    $isSelected = (isset($user) && isset($user->person->costCenter) && $user->person->costCenter->id === $costCenter->id) || old('cost_center_id') == $costCenter->id;
                                @endphp
                                <option value="{{ $costCenter->id }}" @selected($isSelected)>
                                    {{ $formattedCnpj . ' - ' . $companyName . ' / ' . $costCenterName }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group approver-user-box">
                        <label for="approver_user_id" class="regular-text">Usuário aprovador</label>
                        <select name="approver_user_id" id="approver_user_id" data-cy="approver_user_id" class="select2-me" style="width: 100%"
                            data-placeholder="Selecione uma usuário aprovador">
                            <option value=""></option>
                            @foreach ($approvers as $approver)
                                @php
                                    $isSelected = (isset($user) && $user->approver_user_id == $approver->id) || old('approver_user_id') == $approver->id;
                                @endphp
                                <option value="{{ $approver->id }}" @selected($isSelected)>
                                    {{ $approver->person->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group approve-limit-box">
                        <label for="format-approve-limit" class="regular-text"> Limite de aprovação </label>
                        @php
                            $userLimit = isset($user) && $user->approve_limit ? (float) $user->approve_limit : old('approve_limit');
                        @endphp
                        <div class="input-group">
                            <span class="input-group-text">R$</span>
                            <input @if (isset($user) && $user->approve_limit !== null) data-rule-required="true" @endif type="text" id="format-approve-limit" data-cy="format-approve-limit"
                                placeholder="Ex: 100,00" class="form-control format-approve-limit" value="{{ $userLimit }}" @readonly(isset($user) && $user->approve_limit === null)>
                            <input type="hidden" name="approve_limit" id="approve_limit" data-cy="approve_limit" class="approve_limit no-validation"
                                value="{{ old('approve_limit') }}">
                        </div>

                        <div class="no-limit" style="display: flex; align-items: center; gap: 5px; margin-top: 3px;">
                            <input type="checkbox" id="checkbox-has-no-approve-limit" data-cy="checkbox-has-no-approve-limit" class="checkbox-has-no-approve-limit"
                                style="margin:0" @checked((isset($user) && $user->approve_limit === null) || old('checkbox-has-no-approve-limit'))>
                            <label for="checkbox-has-no-approve-limit" style="margin:0;" class="secondary-text"> Sem limite de aprovação </label>
                        </div>
                    </div>
                </div>

                <div class="advanced-user-data-auth">
                    <div class="form-group">
                        <label>Autorização para solicitar: </label>
                        <fieldset data-rule-required="true" class="request-auth-checkbox">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="is_buyer" id="is_buyer_true" data-cy="is_buyer_true" type="radio" value="1"
                                    @checked(!isset($user) || (isset($user) && $user->is_buyer)) data-skin="minimal">
                                <label class="form-check-label" for="is_buyer_true"> Autorizado </label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input"type="radio" name="is_buyer" id="is_buyer_false" data-cy="is_buyer_false" value="0" data-skin="minimal"
                                    @checked(isset($user) && !$user->is_buyer)>
                                <label class="form-check-label" for="commercial"> Não autorizado </label>
                            </div>
                        </fieldset>
                    </div>

                    <div class="form-group">
                        <label>Este usuário pode solicitar para outras pessoas?</label>
                        <fieldset data-rule-required="true" class="request-auth-checkbox">
                            <div class="form-check">
                                <input class="form-check-input" @checked(isset($user) && $user?->can_associate_requester) name="can_associate_requester" id="can-associate-requester"
                                    data-cy="can-associate-requester" type="radio" value="1" data-skin="minimal" required>
                                <label class="form-check-label" for="can-associate-requester"> Sim </label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" @checked(isset($user) && !$user?->can_associate_requester) type="radio" name="can_associate_requester" id="can-not-associate-requester"
                                    data-cy="can-not-associate-requester" value="0" data-skin="minimal" required>
                                <label class="form-check-label" for="can-not-associate-requester"> Não </label>
                            </div>
                        </fieldset>
                    </div>
                </div>

                <div class="form-group cost-center-permissions-box">
                    <label class="regular-text">Centros de custos permitidos</label>

                    <div class="cost-center-box-btns">
                        <a href="#cost-center-permissions" class="btn btn-secondary btn-small cost-center-btn" data-cy="cost-center-btn">
                            Selecionar todos
                        </a>

                        @foreach ($companies as $company)
                            <button type="button" class="btn btn-secondary btn-mini cost-center-btn" data-company-id="{{ $company->id }}" data-bs-toggle='tooltip'
                                data-bs-placement='top'
                                data-bs-title="Adicionar todos centros de custos vinculados a empresa {{ $company->corporate_name }}: {{ preg_replace('/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/', '$1.$2.$3/$4-$5', $company->cnpj) }}">
                                <i class="fa-solid fa-plus"></i> {{ $company->name }}
                            </button>
                        @endforeach
                    </div>

                    <select @disabled(!$isAdmin) name="user_cost_center_permissions[]" id="user_cost_center_permissions" data-cy="user_cost_center_permissions"
                        multiple="multiple" class="select2-me cost-centers-permissions"
                        data-placeholder="Selecione o(s) centro(s) de custo que este usuário possui permissão para compras" data-rule-required="true">
                        @foreach ($costCenters as $costCenter)
                            @php
                                $companyName = $costCenter->company->name;
                                $costCenterName = $costCenter->name;
                                $companyId = $costCenter->company->id;
                            @endphp

                            <option value="{{ $costCenter->id }}" data-company-id="{{ $companyId }}"
                                @if (old('user_cost_center_permissions') !== null) {{ in_array($costCenter->id, old('user_cost_center_permissions')) ? 'selected' : '' }}
                                    @elseif (isset($user) && collect($user->userCostCenterPermission)->contains('costCenter.id', $costCenter->id))
                                        selected @endif>
                                {{ $companyName . ' / ' . $costCenterName }}
                            </option>
                        @endforeach
                    </select>

                    <div class="cost-center-box-btns">
                        <button type="button" class="btn btn-secondary btn-small btn-clear-cost-centers" data-cy="btn-clear-cost-centers">
                            Limpar
                        </button>
                    </div>
                </div>

                <div class="form-group cost-center-permissions-box supplies-cost-center-box">
                    <label class="regular-text" data-bs-toggle='tooltip' data-bs-placement='top'
                        data-bs-title="Apenas para usuários com perfis do tipo suprimentos. Define quais solicitações aparecem na listagem de solicitações do módulo de suprimentos a partir dos centros de custos.">
                        <i class="fa-solid fa-circle-info"></i>
                        Centros de custos permitidos para suprimentos
                    </label>

                    <div class="cost-center-box-btns">
                        <button type="button" class="btn btn-secondary btn-small supplies-cost-center-btn"> Selecionar todos </button>
                        <button type="button" class="btn btn-secondary btn-small supplies-cost-center-btn" data-company-group="{{ CompanyGroup::INP }}"
                            data-bs-toggle="tooltip" data-bs-placement="top"
                            data-bs-title="Padrão do perfil suprimentos INP. Reinicia lista apenas com os centros de custos vinculados a empresas do tipo INP, Noorskin, Oasis...">
                            <i class="fa-solid fa-plus-minus"></i> Apenas INP, Noorskin, Oasis...
                        </button>
                        <button type="button" class="btn btn-secondary btn-small supplies-cost-center-btn" data-company-group="{{ CompanyGroup::HKM }}"
                            data-bs-toggle="tooltip" data-bs-placement="top"
                            data-bs-title="Padrão do perfil suprimentos HKM. Reinicia lista apenas com os centros de custos vinculados a empresas do tipo farmácias e demais empresas...">
                            <i class="fa-solid fa-plus-minus"></i> Apenas Farmácias e demais
                        </button>

                        @foreach ($companies as $company)
                            <button type="button" class="btn btn-secondary btn-mini supplies-cost-center-btn" data-company-id="{{ $company->id }}" data-bs-toggle='tooltip'
                                data-bs-placement='top'
                                data-bs-title="Adicionar todos centros de custos vinculados a empresa {{ $company->corporate_name }}: {{ preg_replace('/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/', '$1.$2.$3/$4-$5', $company->cnpj) }}">
                                <i class="fa-solid fa-plus"></i> {{ $company->name }}
                            </button>
                        @endforeach
                    </div>

                    <select id="supplies-cost-centers" data-cy="supplies-cost-centers" name="supplies_cost_centers[]" multiple="multiple" class="select2-me"
                        data-placeholder="Centro(s) de custo acessíveis em suprimentos">
                        @foreach ($costCenters as $costCenter)
                            @php
                                $companyName = $costCenter->company->name;
                                $costCenterName = $costCenter->name;
                                $companyId = $costCenter->company->id;
                                $companyGroup = $costCenter->company->group;
                                $isSelected = isset($user) && $user->suppliesCostCenters()->exists('id', $costCenter->id);
                            @endphp

                            <option @selected($isSelected) value="{{ $costCenter->id }}" data-company-id="{{ $companyId }}"
                                data-company-group="{{ $companyGroup }}">
                                {{ $companyName . ' / ' . $costCenterName }}
                            </option>
                        @endforeach
                    </select>

                    <div class="cost-center-box-btns">
                        <button type="button" class="btn btn-secondary btn-small clear-supplies-cost-centers">
                            Limpar
                        </button>
                    </div>
                </div>

            </div>
        @endif

        <button id="submit" type="submit" class="btn btn-primary btn-large" data-cy="btn-submit-salvar">
            <div class="spinner-border" role="status"></div>
            Salvar
        </button>
    </form>

    @push('scripts')
        <script type="module">
            $(() => {
                const isRegister = @json($action) === 'register';
                const $btnClearCostCenters = $('.btn-clear-cost-centers');
                const $btnClearSuppliesCostCenters = $('.clear-supplies-cost-centers');
                const $costCenterBtn = $('.cost-center-btn');
                const $suppliesCostCenterBtn = $('.supplies-cost-center-btn');
                const $costCentersPermissions = $('.cost-centers-permissions');
                const $suppliesCostCenters = $('#supplies-cost-centers');
                const $checkboxHasNoApproveLimit = $('.checkbox-has-no-approve-limit');
                const $approveLimit = $('.format-approve-limit');
                const $hiddenApproveLimit = $('.approve_limit');
                const $identificationDocument = $('.cpf_cnpj');
                const $phoneNumber = $('.phone_number');
                const $formUser = $('.form-user');

                const addCostCenters = (event, costCenterSelector) => {
                    const $currentElement = $(event.target);
                    const $companyId = $currentElement.data('company-id');
                    const $companyGroup = $currentElement.data('company-group');
                    const $costCentersOptions = $(`${costCenterSelector} option`);

                    const values = $costCentersOptions.map((_, element) => {
                        if (!$companyId && !$companyGroup) {
                            return $(element).val();
                        }

                        const $optionElement = $(element);

                        const matchCompanyGroup = $optionElement.data('company-group') === $companyGroup;
                        if ($companyGroup && matchCompanyGroup) {
                            return $optionElement.val();
                        }

                        const matchCompanyId = $optionElement.data('company-id') === $companyId;
                        if ((matchCompanyId || $optionElement.is(':selected')) && !$companyGroup) {
                            return $optionElement.val();
                        }
                    });

                    $(costCenterSelector).val(values).trigger('change');
                }

                const submit = (event) => {
                    event.preventDefault();
                    const $form = $(event.target);

                    if (!$form.valid()) {
                        const message = 'Verifique os campos obrigatórios antes de salvar';
                        const title = 'Ops! Verique os campos';
                        const className = 'bg-danger';
                        $.fn.createToast(message, title, className);
                        return false;
                    }

                    const $submitBtn = $('#submit');
                    const $loader = $submitBtn.find('.spinner-border');
                    let stageCompleted = 0;
                    let userId = null;

                    $submitBtn.prop('disabled', true);
                    $loader.show();

                    const formData = $form.serializeArray();
                    const csrfToken = formData.find(el => el.name === "_token");

                    const userData = $(formData).filter((_, element) => element.name !== 'supplies_cost_centers[]').toArray();
                    const suppliesCostCentersData = $(formData).filter((_, element) => element.name === 'supplies_cost_centers[]').toArray();

                    const sendData = async (url, data, successMessage = null) => {
                        try {
                            const response = await $.ajax({
                                url,
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': csrfToken.value
                                },
                                data,
                            });

                            stageCompleted++;

                            const reponseUserId = response.id;
                            if (reponseUserId) {
                                userId = reponseUserId;
                            }

                            if (successMessage) {
                                $.fn.createToast(successMessage, 'Sucesso!', 'bg-success');
                            }
                        } catch (error) {
                            const message = 'Desculpe, ocorreu algum erro no envio dos dados';
                            const title = 'Ops! Algo deu errado';
                            const className = 'bg-warning';
                            $.fn.createToast(message, title, className);

                            stageCompleted = 0;
                        } finally {
                            if (!stageCompleted) {
                                console.error('Erro ao enviar o formulário');
                                $submitBtn.prop('disabled', false);
                                $loader.hide();
                            }
                        }
                    };

                    const action = $form.attr('action');

                    if (isRegister) {
                        sendData(action, userData)
                            .then(() => sendData(`/users/${userId}`, suppliesCostCentersData, 'Usuário criado com sucesso'))
                            .then(() => {
                                const message = 'Redirecionando para lista de usuários';
                                const title = 'Redirecionando...';
                                $.fn.createToast(message, title);
                                setTimeout(() => location.href = '/users', 2000)
                            });
                        return;
                    }

                    Promise.all([sendData(action, userData), sendData(action, suppliesCostCentersData)])
                        .then(() => {
                            const message = 'Usuário atualizado com sucesso. Recarregando página atual...';
                            const title = 'Sucesso! Recarregando...';
                            const className = 'bg-success';
                            $.fn.createToast(message, title, className);
                            setTimeout(() => location.reload(), 2000)
                        })
                };

                $btnClearCostCenters.on('click', () => $costCentersPermissions.val('').trigger("change"));
                $costCenterBtn.on('click', (event) => addCostCenters(event, '.cost-centers-permissions'));

                $btnClearSuppliesCostCenters.on('click', () => $suppliesCostCenters.val('').trigger("change"));
                $suppliesCostCenterBtn.on('click', (event) => addCostCenters(event, '#supplies-cost-centers'));

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

                $formUser.on('submit', submit);
            })
        </script>
    @endpush

</x-app>
