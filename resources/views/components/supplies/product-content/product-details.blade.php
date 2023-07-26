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
@endphp

<x-app>
    <x-slot name="title">
        <h1>Página de suprimentos</h1>
    </x-slot>

    <div class="row" style="padding: 25px 0">
        <div class="col-sm-12">
            <form class="form-validate" method="POST" action="{{ route('supplies.request.status.update', ['id' => $request->id]) }}">
            @csrf
                <div class="row">
                   <div class="col-md-12">
                        <label for="status">Status da solicitação</label>
                   </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <select name="status">
                            @foreach ($allRequestStatus as $status)
                                <option @selected($request->status === $status) value="{{$status}}">{{$status->label()}}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-icon btn-small btn-primary"> Aplicar status </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <h4>Responsável pela solicitação: {{$request->SuppliesUser?->Person->name ?? '---'}} / {{$request->SuppliesUser?->email ?? "---"}}</h4>
        </div>
    </div>

    <div class="request-details">
        <header class="request-details-header">
            <img class="request-details-header-logo"
                src="https://s3.amazonaws.com/gupy5/production/companies/32213/career/73435/images/2022-06-29_14-57_logo.jpg"
                alt="Logo Essentia Group">
            <h1>Solicitação de produto nº {{ $product->id }}</h1>
            <div>
                <span>Criado em: {{ \Carbon\Carbon::parse($product->created_at)->format('d/m/Y h:m:s') }}</span> |
                <span>Atualizado: {{ \Carbon\Carbon::parse($product->updated_at)->format('d/m/Y h:m:s') }}</span>
            </div>
            <p>Desejado para:
                {{ $product->desired_date ? \Carbon\Carbon::parse($product->desired_date)->format('d/m/Y') : '---' }}
            </p>
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
                                    <p><strong>Link de sugestão:</strong>
                                        @if ($request->PurchaseRequestFile->first()?->path)
                                            <a href="{{ $request->PurchaseRequestFile->first()->path }}" target="_blank"
                                                rel="noopener noreferrer">link</a>
                                        @else
                                            ---
                                        @endif
                                    </p>
                                    <p><strong>Motivo da solicitação:</strong> {{ $request->reason }} </p>
                                    <p><strong>Observação:</strong> {{ $request->observation }}</p>
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
                                    <p><strong>Perfil do solicitante:</strong> {{ $request->user->Profile->name }}</p>
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
                                <h4><i class="fa fa-money"></i> <strong>Centro de custo e rateio</strong></h4>
                                <hr>
                                <div class="tab-content padding">
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
                                                        <div class="col-sm-2">
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
                                                        <div class="col-sm-5">
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
                            </div>
                        </div>

                        <div class="request-details-content">
                            <div class="request-details-content-box">
                                <h4><i class="fa fa-tags"></i> <strong>Produto(s) - Informações</strong></h4>
                                <div class="tab-content padding">
                                    @php
                                        $productsGroupedBySupplier = $request->purchaseRequestProduct->groupBy(function ($item) {
                                            return $item->supplier->id;
                                        });
                                    @endphp

                                    @foreach ($productsGroupedBySupplier as $supplierIndex => $supplierGroup)
                                        <div class="request-supplier-group">
                                            <div class="request-details-content-box-supplier">
                                                <h4><strong>Fornecedor nº: {{ $supplierIndex }}</strong></h4>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <p>
                                                            <strong>Razão social:</strong>
                                                            {{ $supplierGroup->first()->supplier->corporate_name }}
                                                        </p>
                                                        <p>
                                                            <strong>Nome fantasia:</strong>
                                                            {{ $supplierGroup->first()->supplier->name }}
                                                        </p>
                                                        <p>
                                                            <strong>CNPJ/CPF:
                                                                {{ $supplierGroup->first()->supplier->cpf_cnpj }}
                                                        </p>
                                                        <p>
                                                            <strong>Tipo de pessoa:</strong>
                                                            {{ $supplierGroup->first()->supplier->entity_type }}
                                                        </p>
                                                        <p>
                                                            <strong>Indicação do fornecedor:</strong>
                                                            {{ $supplierGroup->first()->supplier->supplier_indication }}
                                                        </p>
                                                        <p>
                                                            <strong>Tipo de mercado:</strong>
                                                            {{ $supplierGroup->first()->supplier->market_type }}
                                                        </p>
                                                        <p>
                                                            <strong>Qualificação:</strong>
                                                            {{ $supplierGroup->first()->supplier->qualification->label() }}
                                                        </p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <p>
                                                            <strong>Representante:</strong>
                                                            {{ $supplierGroup->first()->supplier->representative ?? '---' }}
                                                        </p>
                                                        <p>
                                                            <strong>E-mail:</strong>
                                                            {{ $supplierGroup->first()->supplier->email ?? '---' }}
                                                        </p>
                                                        <p>
                                                            <strong>Registro estadual:</strong>
                                                            {{ $supplierGroup->first()->supplier->state_registration }}
                                                        </p>
                                                        <p>
                                                            <strong>Descrição:</strong>
                                                            {{ $supplierGroup->first()->supplier->description ?? '---' }}
                                                        </p>
                                                        <hr>
                                                        <p><strong>
                                                                Fornecedor criado em:</strong>
                                                            {{ $supplierGroup->first()->supplier->created_at }}</p>
                                                        <p>
                                                            <strong>Fornecedor atualizado em:</strong>
                                                            {{ $supplierGroup->first()->supplier->updated_at }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="request-details-content-box-products">
                                                @foreach ($supplierGroup as $index => $productItem)
                                                    <div class="request-details-content-box-products-product">
                                                        <p><strong>Produto nº {{ $index + 1 }}:</strong></p>
                                                        <hr>
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <p>
                                                                    <strong>Quantidade:</strong>
                                                                    {{ $productItem->quantity }}
                                                                </p>
                                                                <p>
                                                                    <strong>Preço unitário:</strong>
                                                                    {{ $productItem->unit_price ?? '---' }}
                                                                </p>
                                                                <p>
                                                                    <strong>Preço total:</strong>
                                                                    {{ $productItem->unit_price ? $productItem->unit_price * $productItem->quantity : 'Indefinido' }}
                                                                </p>
                                                                <hr>
                                                                <p>
                                                                    <strong>Produto criado em:</strong>
                                                                    {{ \Carbon\Carbon::parse($productItem->created_at)->format('d/m/Y h:m:s') }}
                                                                </p>
                                                                <p>
                                                                    <strong>Produto atualizado em:
                                                                        {{ \Carbon\Carbon::parse($productItem->updated_at)->format('d/m/Y h:m:s') }}
                                                                </p>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <p>
                                                                    <strong>Modelo do produto:</strong>
                                                                    {{ $productItem->model ?? '---' }}
                                                                </p>
                                                                <p>
                                                                    <strong>Cor do produto:</strong>
                                                                    {{ $productItem->color ?? '---' }}
                                                                </p>
                                                                <p>
                                                                    <strong>Tamanho e dimensões do produto:</strong>
                                                                    {{ $productItem->size ?? '---' }}
                                                                </p>
                                                                <p>
                                                                    <strong>Categoria:</strong>
                                                                    {{ $productItem->category->name }}
                                                                </p>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <p>
                                                                    <strong>Nome do produto:</strong>
                                                                    {{ $productItem->name }}
                                                                </p>
                                                                <p>
                                                                    <strong>Descrição do produto:</strong>
                                                                    {{ $productItem->description ?? '---' }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
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
</x-app>
