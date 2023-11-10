@php
    use App\Enums\{LogAction, PurchaseRequestType, PurchaseRequestStatus};

    $currentUser = auth()->user();
    $profile = $currentUser->profile->name;

    $isSupplies = match ($profile) {
        'suprimentos_hkm',
        'suprimentos_inp',
        'admin' => true,

        default => false,
    };

    if (isset($contract)) {
        $request = $contract;
    } elseif (isset($product)) {
        $request = $product;
    } elseif (isset($service)) {
        $request = $service;
    } else {
        $request = null;
    }

    $paymentTermProduct = $request->product->paymentInfo?->payment_terms;
    $paymentMethod = $request->product?->paymentInfo?->payment_method;
@endphp

<x-app>
    @if ($isSupplies)
        <div class="row">
            <div class="col-md-12">
                <x-SuppliesRequestEditContainer
                    :request-type="PurchaseRequestType::PRODUCT"
                    :request-id="$request->id"
                    :request-user-id="$request->user_id"
                    :request-status="$request->status"
                    :amount="$request->product->amount"
                    :purchase-order="$request->purchase_order" />
            </div>
        </div>

        <hr>
    @endif

    <div class="row">
        <div class="col-md-12">
            <div class="pull-right">
                <x-PdfGeneratorButton print-by-selector=".details-content" :file-name="'solicitacao_produto_' . $request->id . now()->format('dmY_His_u')" />
            </div>
        </div>
    </div>

    <div class="request-details">
        <div class="details-content">
            <header class="request-details-header">
                <h1 class="text-highlight"><strong>Solicitação de produto nº {{ $product->id }}</strong></h1>
                <div>
                    <span>Criado em: {{ $product->created_at->formatCustom('d/m/Y H:i:s') }}</span> |
                    <span>Atualizado: {{ $product->updated_at?->formatCustom('d/m/Y H:i:s') ?? '---' }}</span>
                </div>

                @if ($product->is_only_quotation)
                    <div class="row only-quotation">
                        <h4>
                            <i class="fa fa-warning">
                            </i><strong> APENAS COTAÇÃO/ORÇAMENTO </strong>
                            <i class="fa fa-warning"></i>
                        </h4>
                    </div>
                @endif

                <div class="row sub-info-container">
                    <h4 class="text-highlight"><strong>Data desejada de entrega do produto:</strong>
                        {{ $product->desired_date ? \Carbon\Carbon::parse($product->desired_date)->format('d/m/Y') : '---' }}
                    </h4>
                    <br>
                    <h4 class="text-highlight"><strong>Responsável pela solicitação (suprimentos):</strong>
                        {{ $request->suppliesUser?->person->name ?? '---' }} /
                        {{ $request->suppliesUser?->email ?? '---' }}
                    </h4>
                    <br>
                    <h4 class="text-highlight"><strong>Responsável pela contratação:</strong>
                        {{ $request->is_supplies_contract ? 'Suprimentos' : 'Área solicitante' }}
                    </h4>
                    <br>
                    <h4 class="text-highlight"><strong>Ordem de compra:</strong>
                        {{ $request->purchase_order ?? '---' }}
                    </h4>
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
                                        <p><strong>Motivo da solicitação:</strong> {{ $request->reason }} </p>
                                        <p><strong>Em qual sala/prédio ficará o produto:</strong>
                                            {{ $request->local_description }} </p>
                                        <p><strong>Compra já realizada:</strong>
                                            {{ $request->product->already_purchased ? 'Sim' : 'Não' }} </p>
                                        <p><strong>Observação:</strong> {{ $request->observation ?? '---' }}</p>
                                    </div>
                                </div>

                                <div class="request-details-content-box">
                                    <h4><i class="fa fa-user"></i> <strong>Informações do solicitante</strong></h4>
                                    <hr>
                                    <div class="tab-content padding">
                                        <p><strong>Quem está solicitando: </strong> {{ $request->requester?->name ?? '---' }}</p>
                                        <p><strong>E-mail do solicitante:</strong> {{ $request->user->email }}</p>
                                        <p><strong>Nome do solicitante:</strong> {{ $request->user->person->name }}</p>
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
                                        <p>
                                            <strong>E-mail do aprovador:</strong>
                                            {{ $request->user->approver->email ?? 'Sem aprovador' }}
                                        </p>
                                        <hr>
                                        <p>
                                            <strong>Usuário criado em:</strong>
                                            {{ $request->user->created_at->formatCustom('d/m/Y H:i:s') }}
                                        </p>
                                        <p>
                                            <strong>Usuário atualizado em:</strong>
                                            {{ $request->user->updated_at?->formatCustom('d/m/Y H:i:s') ?? '---' }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <br>

                            <div class="request-details-content">
                                <div class="request-details-content-box">
                                    <h4>
                                        <i class="fa-solid fa-money-bill"></i> <strong>Centro de custo e rateio</strong>
                                    </h4>
                                    <hr>
                                    <p>
                                        <strong>Quantidade de centro de custos:</strong>
                                        {{ $request->costCenterApportionment->count() }}
                                    </p>

                                    <div class="tab-content request-details-content-box-apportionment">
                                        @foreach ($request->costCenterApportionment as $index => $apportionment)
                                            <div class="row cost-center-box">
                                                <p>Centro de custo nº {{ $index + 1 }}</p>
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

                            <br>

                            <div class="request-details-content-box">

                                <h4><i class="fa fa-truck"></i> <strong>Informações de pagamento</strong></h4>
                                <hr>
                                <div class="tab-content">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <p>
                                                <strong>Nº de parcelas:</strong>
                                                {{ $request->product->quantity_of_installments ?? '---' }}
                                            </p>
                                            <p>
                                                <strong>Valor total:</strong>
                                                R$ {{ $request->product->amount ?? '---' }}
                                            </p>
                                            <p>
                                                <strong>Condição de pagamento: </strong>
                                                {{ $paymentTermProduct?->label() ?? '---' }}
                                            </p>
                                        </div>
                                        <div class="col-sm-6">
                                            <p>
                                                <strong>Forma de pagamento: </strong>
                                                {{ $paymentMethod?->label() ?? '---' }}
                                            </p>
                                            <p>
                                                <strong>Detalhes de pagamento: </strong>
                                                {{ $request->product->paymentInfo->description ?? '---' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="request-details-content-box-product">
                                    <h4 style="padding: 0 15px"><i class="glyphicon glyphicon-list-alt"></i> <strong>
                                            Parcelas</strong></h4>
                                    @foreach ($request->product->installments as $installmentIndex => $installment)
                                        <div class="request-details-content-box-product-installment">
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
                                                    <strong>Valor:</strong> R$ {{ $installment->value }}
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

                            <br>

                            <div class="request-details-content">
                                <div class="request-details-content-box">
                                    <div class="tab-content">
                                        <h4><i class="fa fa-tags"></i> <strong>Produto(s) - Informações</strong></h4>
                                        @php
                                            $productsGroupedBySupplier = $request->purchaseRequestProduct->groupBy(function ($item) {
                                                return $item->supplier?->id;
                                            });

                                            $loopIndex = 0;
                                        @endphp

                                        @foreach ($productsGroupedBySupplier as $supplierIndex => $supplierGroup)
                                            @if ($loopIndex > 0)
                                                <br>
                                                <hr>
                                            @endif
                                            <div class="request-supplier-group">
                                                <div class="request-details-content-box-supplier">
                                                    <h4><i class="fa fa-truck"></i> <strong>Fornecedor
                                                            {{ $supplierIndex !== '' ? 'nº' : '' }}:
                                                            {{ $supplierIndex }}</strong></h4>

                                                    <div class="row">
                                                        <p class="col-sm-4" style="margin: 0">
                                                            <strong>Nome fantasia:</strong>
                                                            {{ $supplierGroup->first()->supplier?->name ?? '---' }}
                                                        </p>
                                                        <p class="col-sm-4" style="margin: 0">
                                                            <strong>CNPJ/CPF:</strong>
                                                            {{ $supplierGroup->first()->supplier?->cpf_cnpj ?? '---' }}
                                                        </p>
                                                        <p class="col-sm-4" style="margin: 0">
                                                            <strong>Razão social:</strong>
                                                            {{ $supplierGroup->first()->supplier?->corporate_name ?? '---' }}
                                                        </p>
                                                    </div>

                                                    <div class="row">
                                                        <p class="col-sm-4" style="margin: 0">
                                                            <strong>Indicação do fornecedor:</strong>
                                                            {{ $supplierGroup->first()->supplier?->supplier_indication ?? '---' }}
                                                        </p>
                                                        <p class="col-sm-4" style="margin: 0">
                                                            <strong>Tipo de mercado:</strong>
                                                            {{ $supplierGroup->first()->supplier?->market_type ?? '---' }}
                                                        </p>

                                                        <p class="col-sm-4" style="margin: 0">
                                                            <strong>Qualificação:</strong>
                                                            {{ $supplierGroup->first()->supplier?->qualification->label() ?? '---' }}
                                                        </p>
                                                    </div>

                                                    <div class="row">
                                                        <p class="col-sm-4" style="margin: 0">
                                                            <strong>Tipo de pessoa:</strong>
                                                            {{ $supplierGroup->first()->supplier?->entity_type ?? '---' }}
                                                        </p>
                                                        <p class="col-sm-4" style="margin: 0">
                                                            <strong>Representante:</strong>
                                                            {{ $supplierGroup->first()->supplier?->representative ?? '---' }}
                                                        </p>
                                                        <p class="col-sm-4" style="margin: 0">
                                                            <strong>Celular/Telefone do responsável:</strong>
                                                            {{ $request->product->phone ?? '---' }}
                                                        </p>
                                                    </div>
                                                    <div class="row">
                                                        <p class="col-sm-4" style="margin: 0">
                                                            <strong>Registro estadual:</strong>
                                                            {{ $supplierGroup->first()->supplier?->state_registration ?? '---' }}
                                                        </p>
                                                        <p class="col-sm-4" style="margin: 0">
                                                            <strong>Descrição:</strong>
                                                            {{ $supplierGroup->first()->supplier?->description ?? '---' }}
                                                        </p>
                                                        <p class="col-sm-4" style="margin: 0">
                                                            <strong>Vendedor/Atendente responsável:</strong>
                                                            {{ $request->product->seller ?? '---' }}
                                                        </p>
                                                    </div>

                                                    <div class="row">
                                                        <p class="col-sm-4" style="margin: 0">
                                                            <strong>Observações tributárias:</strong>
                                                            {{ $supplierGroup->first()->supplier?->tributary_observation ?? '---' }}
                                                        </p>
                                                        <p class="col-sm-4" style="margin: 0">
                                                            <strong>E-mail:</strong>
                                                            {{ $supplierGroup->first()->supplier?->email ?? '---' }}
                                                        </p>
                                                        <p class="col-sm-4" style="margin: 0">
                                                            <strong>E-mail do responsável:</strong>
                                                            {{ $request->product->email ?? '---' }}
                                                        </p>
                                                    </div>

                                                </div>
                                                <div class="request-details-content-box-products">
                                                    @php
                                                        $productCategoryGroups = $supplierGroup->groupBy(function ($item) {
                                                            return $item->category->name;
                                                        });
                                                    @endphp

                                                    @foreach ($productCategoryGroups as $productCategory => $products)
                                                        <br>
                                                        <hr>
                                                        <p><strong><i class="glyphicon glyphicon-th-large"></i>
                                                                Categoria:</strong> {{ $productCategory }}</p>

                                                        @foreach ($products as $index => $productItem)
                                                            <div
                                                                class="request-details-content-box-products-product">
                                                                <p><strong><i class="glyphicon glyphicon-tag"></i>
                                                                        Produto nº {{ $index + 1 }}:</strong></p>

                                                                <div class="row">
                                                                    <p class="col-xs-4" style="margin: 0">
                                                                        <strong>Nome do produto:</strong>
                                                                        {{ $productItem->name }}
                                                                    </p>
                                                                    <p class="col-xs-4" style="margin: 0">
                                                                        <strong>Tamanho e dimensões do produto:</strong>
                                                                        {{ $productItem->size ?? '---' }}
                                                                    </p>
                                                                    <p class="col-xs-4" style="margin: 0">
                                                                        <strong>Quantidade:</strong>
                                                                        {{ $productItem->quantity }}
                                                                    </p>
                                                                </div>

                                                                <div class="row">
                                                                    <p class="col-xs-4" style="margin: 0">
                                                                        <strong>Cor do produto:</strong>
                                                                        {{ $productItem->color ?? '---' }}
                                                                    </p>
                                                                    <p class="col-xs-4" style="margin: 0">
                                                                        <strong>Modelo do produto:</strong>
                                                                        {{ $productItem->model ?? '---' }}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @endforeach
                                                </div>
                                            </div>
                                            @php $loopIndex++; @endphp
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

        <hr>

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

        @if ($isSupplies)
            <div class="row justify-content-center">
                <div class="col-sm-12">
                    <x-RequestFiles :purchaseRequestId="$request?->id" isSupplies :purchaseRequestType="PurchaseRequestType::PRODUCT" />
                </div>
            </div>

            <hr>
        @endif

        <div class="row">
            <div class="col-md-12">
                <x-SuppliesLogList :purchaseRequestId="$request->id" />
            </div>
        </div>

    </div>

    @push('scripts')
        <script type="module" src="{{ asset('js/supplies/details-purchase-request-amount.js') }}"></script>
   @endpush

</x-app>
