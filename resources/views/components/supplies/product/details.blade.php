@php
    if (isset($contract)) {
        $request = $contract;
    } elseif (isset($product)) {
        $request = $product;
    } elseif (isset($service)) {
        $request = $service;
    } else {
        $request = null;
    }

    $requestIsFromLogged = $request->user_id === auth()->user()->id;
@endphp

<x-app>
    <x-slot name="title">
        <h1>Página de suprimentos</h1>
    </x-slot>

    <div class="row">
        <div class="col-sm-12">
            <form class="form-validate" data-cy="form-request-status" method="POST" action="{{ route('supplies.request.status.update', ['id' => $request->id]) }}">
            @csrf
                <div class="row">
                   <div class="col-md-12">
                        <label for="status">Status da solicitação</label>
                   </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <select name="status" data-cy="status" @disabled($requestIsFromLogged)>
                            @foreach ($allRequestStatus as $status)
                                @if ($status->value !== \App\Enums\PurchaseRequestStatus::RASCUNHO->value);
                                    <option @selected($request->status === $status) value="{{$status}}">{{$status->label()}}</option>
                                @endif
                            @endforeach
                        </select>
                        <button data-cy="btn-apply-status" type="submit" class="btn btn-icon btn-small btn-primary" @disabled($requestIsFromLogged)> Aplicar status </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="pull-right">
                <x-PdfGeneratorButton print-by-selector=".details-content" :file-name="'solicitacao_produto_'.$request->id . now()->format('dmY_His_u')"/>
            </div>
        </div>
    </div>

    <div class="request-details">
        <div class="details-content">
            <header class="request-details-header">
                <h1>Solicitação de produto nº {{ $product->id }}</h1>
                <div>
                    <span>Criado em: {{ \Carbon\Carbon::parse($product->created_at)->format('d/m/Y h:m:s') }}</span> |
                    <span>Atualizado: {{ \Carbon\Carbon::parse($product->updated_at)->format('d/m/Y h:m:s') }}</span>
                </div>
                <p>Desejado para:
                    {{ $product->desired_date ? \Carbon\Carbon::parse($product->desired_date)->format('d/m/Y') : '---' }}
                </p>
                <div class="row">
                    <div class="col-md-12">
                        <h4>Responsável pela solicitação: {{$request->suppliesUser?->person->name ?? '---'}} / {{$request->suppliesUser?->email ?? "---"}}</h4>
                    </div>
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
                                        <p><strong>Contratação deve ser por:</strong>
                                            {{ $request->is_supplies_contract ? 'Suprimentos' : 'Centro de custo solicitante' }}
                                        </p>
                                        <p><strong>COMEX:</strong> {{ $request->is_comex ? 'Sim' : 'Não' }}</p>
                                        <p><strong>Motivo da solicitação:</strong> {{ $request->reason }} </p>
                                        <p><strong>Observação:</strong> {{ $request->observation ?? '---' }}</p>
                                        <hr>
                                        <p><strong>Solicitação criada em:</strong>
                                            {{ \Carbon\Carbon::parse($request->created_at)->format('d/m/Y h:m:s') }}</p>
                                        <p><strong>Solicitação atualizada em:</strong>
                                            {{ \Carbon\Carbon::parse($request->updated_at)->format('d/m/Y h:m:s') }}</p>
                                        <p><strong>Solicitação desejada para:</strong>
                                            {{ $request->desired_date ? \Carbon\Carbon::parse($request->desired_date)->format('d/m/Y') : '---' }}
                                        </p>
                                    </div>
                                </div>

                                <div class="request-details-content-box">
                                    <h4><i class="fa fa-user"></i> <strong>Informações do solicitante</strong></h4>
                                    <hr>
                                    <div class="tab-content padding">
                                        <p><strong>E-mail do solicitante:</strong> {{ $request->user->email }}</p>
                                        <p><strong>Nome do solicitante:</strong> {{ $request->user->person->name }}</p>
                                        <p><strong>Documento do solicitante:</strong>
                                            {{ $request->user->person->cpf_cnpj }}
                                        </p>
                                        <p>
                                            <strong>Celular/Telefone:</strong> {{ $request->user->person->phone->number }}
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
                                            {{ \Carbon\Carbon::parse($request->user->created_at)->format('d/m/Y h:m:s') }}
                                        </p>
                                        <p>
                                            <strong>Usuário atualizado em:</strong>
                                            {{ \Carbon\Carbon::parse($request->user->updated_at)->format('d/m/Y h:m:s') }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="request-details-content">
                                <div class="request-details-content-box">
                                    <h4>
                                        <i class="fa fa-money"></i> <strong>Centro de custo e rateio</strong>
                                    </h4>
                                    <hr>
                                    <p>
                                        <strong>Quantidade de centro de custos:</strong>
                                        {{ $request->costCenterApportionment->count() }}
                                    </p>

                                    <div class="tab-content request-details-content-box-apportionment">
                                        @foreach ($request->costCenterApportionment as $index => $apportionment)
                                            <div class="row">
                                                <p>Centro de custo nº {{ $index + 1 }}</p>
                                                <div class="col-sm-3">
                                                    <p>
                                                        <strong>Porcentagem (%):</strong> {{ $apportionment->apportionment_percentage ?? '---' }}
                                                    </p>
                                                    <p>
                                                        <strong>Custo (R$):</strong> {{ $apportionment->apportionment_currency ?? '---' }}
                                                    </p>
                                                </div>
                                                <div class="col-sm-5">
                                                    <p>
                                                        <strong>Centro de custo:</strong> {{ $apportionment->costCenter->name }}
                                                    </p>
                                                    <p>
                                                        <strong>CNPJ:</strong> {{ $apportionment->costCenter->company->cnpj }}
                                                    </p>
                                                </div>
                                                <div class="col-sm-4">
                                                    <p>
                                                        <strong>Empresa:</strong> {{ $apportionment->costCenter->company->corporate_name }}
                                                    </p>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="request-details-content-box">

                                <h4><i class="fa fa-truck"></i> <strong>Informações de pagamento</strong></h4>
                                <hr>
                                <div class="tab-content">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <p>
                                                <strong>Vendedor:</strong>
                                                {{ $request->product->seller ?? '---' }}
                                            </p>
                                            <p>
                                                <strong>Celular de contato:</strong>
                                                {{ $request->product->phone ?? '---' }}
                                            </p>
                                        </div>
                                        <div class="col-sm-4">
                                            <p>
                                                <strong>Nº de parcelas:</strong>
                                                {{ $request->product->quantity_of_installments ?? '---' }}
                                            </p>
                                            <p>
                                                <strong>Valor total:</strong>
                                                R$ {{ $request->product->amout ?? '---' }}
                                            </p>
                                        </div>
                                        <div class="col-sm-4">
                                            <p>
                                                <strong>Quitação:</strong>
                                                Pgto. {{ $request->product->is_prepaid ? 'antecipado' : 'pós-pago' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="request-details-content-box-product">
                                    <h4 style="padding: 0 15px"><i class="glyphicon glyphicon-list-alt"></i> <strong> Parcelas</strong></h4>
                                    @foreach ($request->product->installments as $installmentIndex => $installment)
                                    <div class="request-details-content-box-product-installment">
                                        <div class="row">
                                            <p class="col-xs-3">
                                                <strong>Parcela nº:</strong> {{ $installmentIndex + 1 }}
                                            </p>
                                            <p class="col-xs-3">
                                                <strong>Quitação:</strong> {{ $installment->status ?? '---' }}
                                            </p>
                                            <p class="col-xs-3">
                                                <strong>Serviço executado:</strong> {{ $installment->already_provided ? 'Sim' : 'Não' }}
                                            </p>
                                        </div>
                                        <div class="row">
                                            <p class="col-xs-3">
                                                <strong>Valor:</strong> {{ $installment->value }}
                                            </p>
                                            <p class="col-xs-3">
                                                <strong>Vencimento:</strong> {{$installment->expire_date ? \Carbon\Carbon::parse($installment->expire_date)->format('d/m/Y') : '---'}}
                                            </p>
                                            <p class="col-xs-6">
                                                <strong>Observação do pagamento:</strong> <span>{{ $installment->observation ?? '---' }}</span>
                                            </p>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="request-details-content">
                                <div class="request-details-content-box">
                                    <div class="tab-content">
                                        <h4><i class="fa fa-tags"></i> <strong>Produto(s) - Informações</strong></h4>
                                        @php
                                            $productsGroupedBySupplier = $request->purchaseRequestProduct->groupBy(function ($item) {
                                                return $item->supplier->id;
                                            });

                                            $loopIndex = 0;
                                        @endphp

                                        @foreach ($productsGroupedBySupplier as $supplierIndex => $supplierGroup)
                                            @if ($loopIndex > 0)
                                                <hr class="pagebreak">
                                            @endif
                                            <div class="request-supplier-group">
                                                <div class="request-details-content-box-supplier">
                                                    <h4><i class="fa fa-truck"></i> <strong>Fornecedor nº: {{ $supplierIndex }}</strong></h4>

                                                    <div class="row">
                                                        <p class="col-sm-4" style="margin: 0">
                                                            <strong>Nome fantasia:</strong> {{ $supplierGroup->first()->supplier->name }}
                                                        </p>
                                                        <p class="col-sm-4" style="margin: 0">
                                                            <strong>CNPJ/CPF:</strong> {{ $supplierGroup->first()->supplier->cpf_cnpj }}
                                                        </p>
                                                        <p class="col-sm-4" style="margin: 0">
                                                            <strong>Razão social:</strong> {{ $supplierGroup->first()->supplier->corporate_name }}
                                                        </p>
                                                    </div>

                                                    <div class="row">
                                                        <p class="col-sm-4" style="margin: 0">
                                                            <strong>Indicação do fornecedor:</strong> {{ $supplierGroup->first()->supplier->supplier_indication }}
                                                        </p>
                                                        <p class="col-sm-4" style="margin: 0">
                                                            <strong>Tipo de mercado:</strong> {{ $supplierGroup->first()->supplier->market_type }}
                                                        </p>

                                                        <p class="col-sm-4" style="margin: 0">
                                                            <strong>Qualificação:</strong> {{ $supplierGroup->first()->supplier->qualification->label() }}
                                                        </p>
                                                    </div>

                                                    <div class="row" >
                                                        <p class="col-sm-4" style="margin: 0">
                                                            <strong>Tipo de pessoa:</strong>
                                                            {{ $supplierGroup->first()->supplier->entity_type }}
                                                        </p>
                                                        <p class="col-sm-4" style="margin: 0">
                                                            <strong>Representante:</strong> {{ $supplierGroup->first()->supplier->representative ?? '---' }}
                                                        </p>
                                                        <p class="col-sm-4" style="margin: 0">
                                                            <strong>E-mail:</strong> {{ $supplierGroup->first()->supplier->email ?? '---' }}
                                                        </p>
                                                    </div>

                                                    <div class="row">
                                                        <p class="col-sm-4" style="margin: 0">
                                                            <strong>Registro estadual:</strong> {{ $supplierGroup->first()->supplier->state_registration }}
                                                        </p>
                                                        <p class="col-sm-4" style="margin: 0">
                                                            <strong>Descrição:</strong> {{ $supplierGroup->first()->supplier->description ?? '---' }}
                                                        </p>
                                                        <p class="col-sm-4" style="margin: 0">
                                                            <strong>Fornecedor criado em:</strong> {{ $supplierGroup->first()->supplier->created_at }}
                                                        </p>
                                                    </div>

                                                    <div class="row">
                                                        <p class="col-sm-4" style="margin: 0">
                                                            <strong>Fornecedor atualizado em:</strong> {{ $supplierGroup->first()->supplier->updated_at }}
                                                        </p>
                                                        <p class="col-sm-4" style="margin: 0">
                                                            <strong>Observações tributárias:</strong> {{ $supplierGroup->first()->supplier->tributary_observation ?? '---' }}
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
                                                        <hr>
                                                        <p><strong><i class="glyphicon glyphicon-th-large"></i> Categoria:</strong> {{$productCategory}}</p>

                                                        @foreach ($products as $index => $productItem)
                                                            <div class="request-details-content-box-products-product {{ $index % 2 === 0 ? 'zebra-bg-even' : 'zebra-bg-odd' }}">
                                                                <p><strong><i class="glyphicon glyphicon-tag"></i> Produto nº {{ $index + 1 }}:</strong></p>

                                                                <div class="row">
                                                                    <p class="col-xs-4" style="margin: 0">
                                                                        <strong>Nome do produto:</strong> {{ $productItem->name }}
                                                                    </p>
                                                                    <p class="col-xs-4" style="margin: 0">
                                                                        <strong>Tamanho e dimensões do produto:</strong> {{ $productItem->size ?? '---' }}
                                                                    </p>
                                                                    <p class="col-xs-4" style="margin: 0">
                                                                        <strong>Preço total:</strong> {{ $productItem->unit_price ? $productItem->unit_price * $productItem->quantity : 'Indefinido' }}
                                                                    </p>
                                                                </div>

                                                                <div class="row">
                                                                    <p class="col-xs-4" style="margin: 0">
                                                                        <strong>Quantidade:</strong> {{ $productItem->quantity }}
                                                                    </p>
                                                                    <p class="col-xs-4" style="margin: 0">
                                                                        <strong>Modelo do produto:</strong> {{ $productItem->model ?? '---' }}
                                                                    </p>
                                                                    <p class="col-xs-4" style="margin: 0">
                                                                        <strong>Descrição do produto:</strong> {{ $productItem->description ?? '---' }}
                                                                    </p>
                                                                </div>

                                                                <div class="row">
                                                                    <p class="col-xs-4" style="margin: 0">
                                                                        <strong>Preço unitário:</strong> {{ $productItem->unit_price ?? '---' }}
                                                                    </p>
                                                                    <p class="col-xs-4" style="margin: 0">
                                                                        <strong>Cor do produto:</strong> {{ $productItem->color ?? '---' }}
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

        <div class="row">
            <div class="col-md-12">
                 <h4><i class="glyphicon glyphicon-file"></i> <strong>Anexos:</strong></h4>
                 @if ($files->count())
                    <ul>
                        @foreach ($files as $index => $file)
                            <li><a style="font-size: 16px" data-cy="link-{{ $index }}" href="{{ env('AWS_S3_BASE_URL') . $file->path }}" target="_blank" rel="noopener noreferrer">{{ $file->original_name }}</a></li>
                        @endforeach
                    </ul>
                 @else
                    <p>Ainda não há registros aqui.</p>
                 @endif
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <h4><i class="glyphicon glyphicon-link"></i> <strong>Links de apoio/sugestão:</strong></h4>
                @php
                    $supportLinks = 'Não há links para serem exibidos aqui.';
                    if( $request?->support_links) {
                        $supportLinks = str_replace(' ', '<br>', $request->support_links);
                        $supportLinks = nl2br($supportLinks);
                    }
                @endphp
                <p class="support_links" style="max-height: 300px; overflow:auto">{!! $supportLinks !!}</p>
            </div>
        </div>
    </div>
</x-app>