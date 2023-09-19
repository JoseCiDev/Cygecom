@php
    use App\Enums\{PaymentTerm, LogAction, PurchaseRequestType, PurchaseRequestStatus};

    if (isset($contract)) {
        $request = $contract;
    } elseif (isset($product)) {
        $request = $product;
    } elseif (isset($service)) {
        $request = $service;
    } else {
        $request = null;
    }

    $paymentTermContract = $request->contract?->paymentInfo?->payment_terms;
@endphp

<x-app>

    <div class="row">
        <div class="col-md-12">
            <x-SuppliesRequestEditContainer
                :request-type="PurchaseRequestType::CONTRACT"
                :request-id="$request->id"
                :request-user-id="$request->user_id"
                :request-status="$request->status"
                :amount="$request->contract->amount"/>
        </div>
    </div>

    <hr>

    <div class="row">
        <div class="col-md-12">
            <div class="pull-right">
                <x-PdfGeneratorButton print-by-selector=".details-content" :file-name="'solicitacao_contrato_' . $request->id . now()->format('dmY_His_u')" />
            </div>
        </div>
    </div>

    <div class="request-details">
        <div class="details-content">
            <header class="request-details-header">
                <h1 class="text-highlight"><strong>Solicitação de contrato nº {{ $request->id }}</strong></h1>
                <div>
                    <span>Criado em: {{ \Carbon\Carbon::parse($request->created_at)->format('d/m/Y h:m:s') }}</span> |
                    <span>Atualizado: {{ \Carbon\Carbon::parse($request->updated_at)->format('d/m/Y h:m:s') }}</span>
                </div>

                @if ($contract->is_only_quotation)
                    <div class="row only-quotation">
                        <h4>
                            <i class="fa fa-warning">
                                </i><strong> APENAS COTAÇÃO/ORÇAMENTO </strong>
                            <i class="fa fa-warning"></i>
                        </h4>
                    </div>
                @endif

                <div class="row sub-info-container">
                    <h4 class="text-highlight">
                        <strong>Nome do contrato:</strong>
                        {{ $request->contract->name }}
                    </h4>
                    <br>
                    <h4 class="text-highlight">
                        <strong>
                            {{ $request->is_supplies_contract ? 'Data desejada da contratação:' : 'Data da contratação:' }}
                        </strong>
                        {{ $request->desired_date ? \Carbon\Carbon::parse($request->desired_date)->format('d/m/Y') : '---' }}
                    </h4>
                    <br>
                    <h4 class="text-highlight"><strong>Responsável pela solicitação (suprimentos):</strong>
                        {{ $request->suppliesUser?->person->name ?? '---' }} /
                        {{ $request->suppliesUser?->email ?? '---' }}</h4>
                    <br>
                    <h4 class="text-highlight"><strong>Responsável pela contratação:</strong>
                        {{ $request->is_supplies_contract ? 'Suprimentos' : 'Área solicitante' }} </h4>
                    <br>
                </div>
            </header>
            <main>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="box box-bordered">
                            <div class="box-title">
                                <h2 class="request-title">Detalhes da solicitação</h2>
                            </div>
                            <div class="request-details-content">

                                <div class="request-details-content-box">
                                    <h4><i class="fa fa-info"></i> <strong>Informações básicas</strong></h4>
                                    <hr>
                                    <div class="tab-content padding">
                                        <p><strong>Status de aprovação:</strong> {{ $request->status->label() }}</p>
                                        <p><strong>Tipo de solicitação:</strong> {{ $request->type->label() }}</p>
                                        <p><strong>COMEX:</strong> {{ $request->is_comex ? 'Sim' : 'Não' }}</p>
                                        <p>
                                            <strong>Motivo da solicitação:</strong> {{ $request->reason }}
                                        </p>
                                        <p>
                                            <strong>Observação:</strong> {{ $request->observation ?? '---' }}
                                        </p>
                                        <hr>
                                        <p>
                                            <strong>Solicitação criada em:</strong>
                                            {{ \Carbon\Carbon::parse($request->created_at)->format('d/m/Y h:m:s') }}
                                        </p>
                                        <p>
                                            <strong>Solicitação atualizada em:</strong>
                                            {{ \Carbon\Carbon::parse($request->updated_at)->format('d/m/Y h:m:s') }}
                                        </p>
                                        <p>
                                            <strong>Solicitação desejada para:</strong>
                                            {{ $request->desired_date ? \Carbon\Carbon::parse($request->desired_date)->format('d/m/Y') : '---' }}
                                        </p>
                                    </div>
                                </div>

                                <div class="request-details-content-box">
                                    <h4><i class="fa fa-user"></i> <strong>Informações do solicitante</strong></h4>
                                    <hr>
                                    <div class="tab-content padding">
                                        <p>
                                            <strong>E-mail do solicitante:</strong> {{ $request->user->email }}
                                        </p>
                                        <p>
                                            <strong>Nome do solicitante:</strong> {{ $request->user->person->name }}
                                        </p>
                                        <p>
                                            <strong>Documento do solicitante:</strong>
                                            {{ $request->user->person->cpf_cnpj }}
                                        </p>
                                        <p>
                                            <strong>Celular/Telefone:</strong>
                                            {{ $request->user->person->phone->number }}
                                        </p>
                                        <p>
                                            <strong>Centro de custo do solicitante:</strong>
                                            {{ $request->user->person->costCenter->name }}
                                        </p>
                                        <p>
                                            <strong>Empresa do centro de custo:</strong>
                                            {{ $request->user->person->costCenter->company->corporate_name }}
                                        </p>
                                        <hr>
                                        <p>
                                            <strong>Autorização para solicitar:</strong>
                                            {{ $request->user->is_buyer ? 'Autorizado' : 'Sem autorização' }}
                                        </p>
                                        <p>
                                            <strong>Aprovação limite:</strong>
                                            {{ $request->user->approver_limit ?? 'Sem limite' }}
                                        </p>
                                        <p>
                                            <strong>Usuário aprovador:</strong>
                                            {{ $request->user->approver->person->name ?? 'Sem aprovador' }}
                                        </p>
                                        <hr>
                                        <p>
                                            <strong>Usuário criado em:</strong>
                                            {{ \Carbon\Carbon::parse($request->user->created_at)->format('d/m/Y h:m:s') }}
                                        </p>
                                        <p>
                                            <strong>Usuário atualizado em:</strong>
                                            {{ \Carbon\Carbon::parse($request->user->updated_at)->format('d/m/Y h:m:s') }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <br>

                            <div class="request-details-content">
                                <div class="request-details-content-box">
                                    <h4><i class="fa fa-money"></i> <strong>Centro de custo e rateio</strong></h4>
                                    <hr>
                                    <div class="tab-content padding">
                                        <p>
                                            <strong>Qtd. de centro de custos:</strong>
                                            {{ $request->costCenterApportionment->count() }}
                                        </p>
                                        <div class="tab-content request-details-content-box-apportionment">
                                            @foreach ($request->costCenterApportionment as $index => $apportionment)
                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <p>
                                                            <strong>Porcentagem (%):</strong>
                                                            {{ $apportionment->apportionment_percentage ?? '---' }}
                                                        </p>
                                                        <p>
                                                            <strong>Custo (R$):</strong>
                                                            {{ $apportionment->apportionment_currency ?? '---' }}
                                                        </p>
                                                    </div>
                                                    <div class="col-sm-5">
                                                        <p>
                                                            <strong>Centro de custo:</strong>
                                                            {{ $apportionment->costCenter->name }}
                                                        </p>
                                                        <p>
                                                            <strong>CNPJ:</strong>
                                                            {{ $apportionment->costCenter->company->cnpj }}
                                                        </p>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <p>
                                                            <strong>Empresa:</strong>
                                                            {{ $apportionment->costCenter->company->corporate_name }}
                                                        </p>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <br>

                            <div class="request-details-content">
                                <div class="request-details-content-box">
                                    <h4><i class="fa fa-truck"></i> <strong>Fornecedor</strong></h4>
                                    <hr>
                                    <div class="tab-content">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <p>
                                                    <strong>Razão social:</strong>
                                                    {{ $request->contract?->supplier?->corporate_name ?? '---' }}
                                                </p>
                                                <p>
                                                    <strong>Nome fantasia:</strong>
                                                    {{ $request->contract?->supplier->name ?? '---' }}
                                                </p>
                                                <p>
                                                    <strong>CPF/CNPJ:</strong>
                                                    @php
                                                        $cnpj = $request->contract?->supplier?->cpf_cnpj ? preg_replace('/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/', '$1.$2.$3/$4-$5', $request->contract?->supplier?->cpf_cnpj) : 'CNPJ indefinido'
                                                    @endphp
                                                    {{ $cnpj }}
                                                </p>
                                                <p>
                                                    <strong>Indicação:</strong>
                                                    {{ $request->contract?->supplier->supplier_indication ?? '---' }}
                                                </p>
                                                <p>
                                                    <strong>Qualifacação:</strong>
                                                    {{ $request->contract->supplier?->qualification->label() ?? '---' }}
                                                </p>
                                            </div>
                                            <div class="col-sm-4">
                                                <p>
                                                    <strong>Tipo de mercado:</strong>
                                                    {{ $request->contract?->supplier->market_type ?? '---' }}
                                                </p>
                                                <p>
                                                    <strong>Representante:</strong>
                                                    {{ $request->contract?->supplier->representative ?? '---' }}
                                                </p>
                                                <p>
                                                    <strong>E-mail do fornecedor:</strong>
                                                    {{ $request->contract?->supplier->email ?? '---' }}
                                                </p>
                                                <p>
                                                    <strong>Descrição:</strong>
                                                    {{ $request->contract->supplier->description ?? '---' }}
                                                </p>
                                                <p>
                                                    <strong>Observações tributárias:</strong>
                                                    {{ $request->contract->supplier->tributary_observation ?? '---' }}
                                                </p>
                                            </div>
                                            <div class="col-sm-4">
                                                <p>
                                                    <strong>Tipo de pessoa:</strong>
                                                    {{ $request->contract->supplier?->entity_type ?? '---' }}
                                                </p>
                                                <p>
                                                    <strong>Registro estadual:</strong>
                                                    {{ $request->contract->supplier->state_registration ?? '---' }}
                                                </p>
                                                <hr>
                                                <p>
                                                    <strong>Vendedor/Atendente:</strong>
                                                    {{ $request->contract->seller ?? '---' }}
                                                </p>
                                                <p>
                                                    <strong>Telefone do vendedor:</strong>
                                                    {{ $request->contract->phone ?? '---' }}
                                                </p>
                                                <p>
                                                    <strong>E-mail do vendedor:</strong>
                                                    {{ $request->contract->email ?? '---' }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <br>

                            <div class="request-details-content">
                                <div class="request-details-content-box">
                                    <h4><i class="glyphicon glyphicon-list-alt"></i> <strong>Contrato -
                                            Informações</strong></h4>
                                    <div class="tab-content padding">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <p>
                                                    <strong>Recorrência do pagamento:</strong>
                                                    {{ $request->contract->recurrence?->label() ?? '---' }}
                                                </p>
                                                <p>
                                                    @php
                                                        if ($request->contract->is_fixed_payment === null) {
                                                            $isFixedPayment = '---';
                                                        } elseif ((bool) $request->contract->is_fixed_payment) {
                                                            $isFixedPayment = 'Pgto. fixo';
                                                        } else {
                                                            $isFixedPayment = 'Pgto. variável';
                                                        }
                                                    @endphp
                                                    <strong>Flexibilidade do pagamento:</strong>
                                                    {{ $isFixedPayment }}
                                                </p>
                                                <p>
                                                    <strong>Condição de pagamento:</strong>
                                                    {{ $paymentTermContract?->label() ?? '---' }}
                                                </p>
                                                <p>
                                                    <strong>Local da prestação serviço:</strong>
                                                    {{ $request?->local_description ?? '---' }}
                                                </p>
                                                <p>
                                                    <strong>Valor total do contrato (R$):</strong>
                                                    {{ $request->contract?->amount ?? '---' }}
                                                </p>
                                                <p>
                                                    <strong>Qtd. de parcelas:</strong>
                                                    {{ $request->contract?->installments->count() ?? '---' }}
                                                </p>


                                            </div>
                                            <div class="col-md-4">
                                                <p>
                                                    <strong>Forma do pagamento:</strong>
                                                    {{ $request->contract->paymentInfo?->payment_method?->label() ?? '---' }}
                                                </p>
                                                <p>
                                                    <strong>Detalhes de pagamento:</strong>
                                                    {{ $request->contract->paymentInfo?->description ?? '---' }}
                                                </p>
                                                <hr>
                                                <p>
                                                    <strong>Detalhes do contrato: </strong>
                                                    {{ $request?->description ?? '---' }}
                                                </p>
                                            </div>
                                            <div class="col-md-4">
                                                <p>
                                                    <strong>Dia de vencimento:</strong>
                                                    {{ $request->contract->payday ?? '---' }}
                                                </p>
                                                <p>
                                                    <strong>Vigência - Dia de início:</strong>
                                                    {{ $request->contract->start_date ? Carbon\Carbon::parse($request->contract->start_date)->format('d/m/Y') : '---' }}
                                                </p>
                                                <p>
                                                    <strong>Vigência - Dia de fim:</strong>
                                                    {{ $request->contract->end_date ? Carbon\Carbon::parse($request->contract->end_date)->format('d/m/Y') : 'Indeterminada' }}
                                                </p>
                                            </div>
                                        </div>

                                    </div>

                                    <br>

                                    <div class="request-details-content-box-contract">
                                        <h4 style="padding: 0 15px"><i class="glyphicon glyphicon-list-alt"></i>
                                            <strong> Parcelas</strong></h4>
                                        @foreach ($request->contract->installments as $installmentIndex => $installment)
                                            <div class="request-details-content-box-contract-installment">
                                                <div class="row">
                                                    <p class="col-xs-3">
                                                        <strong>Parcela nº:</strong> {{ $installmentIndex + 1 }}
                                                    </p>
                                                    <p class="col-xs-3">
                                                        <strong>Quitação:</strong> {{ $installment->status ?? '---' }}
                                                    </p>
                                                    <p class="col-xs-6">
                                                        <strong>Observação do pagamento:</strong>
                                                        <span>{{ $installment->observation ?? '---' }}</span>
                                                    </p>
                                                </div>
                                                <div class="row">
                                                    <p class="col-xs-3">
                                                        <strong>Valor:</strong> {{ $installment->value }}
                                                    </p>
                                                    <p class="col-xs-3">
                                                        <strong>Vencimento:</strong>
                                                        {{ $installment->expire_date ? \Carbon\Carbon::parse($installment->expire_date)->format('d/m/Y') : '---' }}
                                                    </p>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>


                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </main>
        </div>

        <hr>

        <div class="row">
            <div class="col-md-12">
                <h4><i class="glyphicon glyphicon-file"></i> <strong>Anexos:</strong></h4>
                @if ($files->count())
                    <ul>
                        @foreach ($files as $index => $file)
                            <li><a style="font-size: 16px" data-cy="link-{{ $index }}"
                                    href="{{ env('AWS_S3_BASE_URL') . $file->path }}" target="_blank"
                                    rel="noopener noreferrer">{{ $file->original_name }}</a></li>
                        @endforeach
                    </ul>
                @else
                    <p>Nenhum registro encontrado.</p>
                @endif
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <h4><i class="glyphicon glyphicon-link"></i> <strong>Links de apoio/sugestão:</strong></h4>
                @php
                    $supportLinks = 'Não há links para serem exibidos.';
                    if ($request?->support_links) {
                        $supportLinks = str_replace(' ', '<br>', $request->support_links);
                        $supportLinks = nl2br($supportLinks);
                    }
                @endphp
                <p class="support_links" style="max-height: 300px; overflow:auto">{!! $supportLinks !!}</p>
            </div>
        </div>

        <hr>

        <div class="row justify-content-center">
            <div class="col-sm-12">
                <x-RequestFiles :purchaseRequestId="$request?->id" isSupplies :purchaseRequestType="PurchaseRequestType::CONTRACT" />
            </div>
        </div>

        <hr>

        <div class="row">
            <div class="col-md-12">
                <x-SuppliesLogList :purchaseRequestId="$request->id" />
            </div>
        </div>


    </div>

    <x-slot:scripts>
        <script src="{{ asset('js/supplies/details-purchase-request-amount.js') }}"></script>
    </x-slot:scripts>

</x-app>
