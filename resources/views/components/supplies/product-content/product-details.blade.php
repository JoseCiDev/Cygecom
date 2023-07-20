@php
    if(isset($contract)) {
        $request = $contract;
    } else if(isset($product)) {
        $request = $product;
    } else if(isset($service)) {
        $request = $service;
    } else {
        $request = null;
    }
@endphp

<x-app>
    <x-slot name="title">
        <h1>Página de suprimentos</h1>
    </x-slot>

  <div class="request-details">
        <header class="request-details-header">
            <img class="request-details-header-logo" src="https://s3.amazonaws.com/gupy5/production/companies/32213/career/73435/images/2022-06-29_14-57_logo.jpg" alt="Logo Essentia Group">
            <h1>Solicitação de produto nº {{$product->id}}</h1>
            <div>
                <span>Criado em: {{ \Carbon\Carbon::parse($product->created_at)->format('d/m/Y h:m:s') }}</span> | <span>Atualizado: {{ \Carbon\Carbon::parse($product->updated_at)->format('d/m/Y h:m:s') }}</span>
            </div>
            <p>Desejado para: {{$product->desired_date ? \Carbon\Carbon::parse($product->desired_date)->format('d/m/Y') : "---"}}</p>
        </header>
        <main>
            <div class="row">
                <div class="col-sm-12">
                    <div class="box box-bordered">
                        <div class="box-title"> <h2 class="request-title">Detalhes da solicitação</h2> </div>
                        <div class="request-details-content">

                            <div class="request-details-content-box">
                                <p><i class="fa fa-info"></i> Informações básicas</p>
                                <hr>
                                <div class="tab-content padding">
                                    <p>Nº da solicitação: {{$request->id}}</p>
                                    <p>Nº do solicitante: {{$request->user_id}}</p>
                                    <p>Status de aprovação: {{$request->status->label()}}</p>
                                    <p>Tipo de solicitação: {{$request->type->label()}}</p>
                                    <p>Contratação deve ser por: {{$request->is_supplies_contract ? 'Suprimentos' : 'Centro de custo solicitante'}}</p>
                                    <p>COMEX: {{$request->is_comex ? 'Sim' : 'Não'}}</p>
                                    <p>Link de sugestão: 
                                        @if ($request->PurchaseRequestFile->first()?->path) 
                                            <a href="{{$request->PurchaseRequestFile->first()->path}}" target="_blank" rel="noopener noreferrer">link</a>
                                        @else
                                        ---
                                        @endif
                                    </p>
                                    <label>Motivo da solicitação: 
                                        <textarea class="no-resize" style="display:block" readonly cols="70" rows="6">{{$request->reason}}</textarea>
                                    </label>
                                    <label>Observação: 
                                        <textarea class="no-resize" style="display:block" readonly cols="70" rows="6">{{$request->observation}}</textarea>
                                    </label>
                                    <hr>
                                    <p>Solicitação criada em: {{ \Carbon\Carbon::parse($request->created_at)->format('d/m/Y h:m:s') }}</p> 
                                    <p>Solicitação atualizada em: {{ \Carbon\Carbon::parse($request->updated_at)->format('d/m/Y h:m:s') }}</p>
                                    <p>Solicitação desejada para: {{$request->desired_date ? \Carbon\Carbon::parse($request->desired_date)->format('d/m/Y') : "---"}}</p>
                                </div>
                            </div>

                            <div class="request-details-content-box">
                                <p><i class="fa fa-user"></i> Informações do solicitante</p>
                                <hr>
                                <div class="tab-content padding">
                                    <p>Nº do solicitante: {{$request->user_id}}</p>
                                    <p>E-mail do solicitante: {{$request->user->email}}</p>
                                    <p>Nome do solicitante: {{$request->user->person->name}}</p>
                                    <p>Documento do solicitante: {{$request->user->person->cpf_cnpj}}</p>
                                    <p>Celular/Telefone: {{$request->user->person->phone->number}}</p>
                                    <p>Centro de custo do solicitante: {{$request->user->person->costCenter->name}}</p>
                                    <p>Empresa do centro de custo: {{$request->user->person->costCenter->company->corporate_name}}</p>
                                    <hr>
                                    <p>Perfil do solicitante: {{$request->user->Profile->name}}</p>
                                    <p>Autorização para solicitar: {{$request->user->is_buyer ? 'Autorizado' : 'Sem autorização'}}</p>
                                    <p>Aprovação limite: {{$request->user->approver_limit ?? 'Sem limite'}}</p>
                                    <p>Nº do aprovador: {{$request->user->approver_user_id ?? 'Sem aprovador'}}</p>
                                    <hr>
                                    <p>Usuário criado em: {{ \Carbon\Carbon::parse($request->user->created_at)->format('d/m/Y h:m:s') }}</p> 
                                    <p>Usuário atualizado em: {{ \Carbon\Carbon::parse($request->user->updated_at)->format('d/m/Y h:m:s') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="request-details-content">
                            <div class="request-details-content-box">
                                <p><i class="fa fa-money"></i> Centro de custo e rateio</p>
                                <hr>
                                <div class="tab-content padding">
                                    <p>Qtd. de centro de custos: {{$request->costCenterApportionment->count()}}</p>

                                    <div class="request-details-content-box-apportionment">
                                        @foreach ($request->costCenterApportionment as $index => $apportionment)
                                        <div>
                                            <p>Centro de custo nº {{$index}}</p>
                                            <ul>
                                                <p>Porcentagem (%): {{$apportionment->apportionment_percentage ?? '---'}}</p>
                                                <p>Custo (R$): {{$apportionment->apportionment_currency ?? '---'}}</p>
                                                <p>Centro de custo: {{$apportionment->costCenter->name}}</p>
                                                <p>Empresa: {{$apportionment->costCenter->company->corporate_name}}</p>
                                                <p>CNPJ: {{$apportionment->costCenter->company->cnpj}}</p>
                                            </ul>
                                        </div>
                                        @endforeach
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                        
                        <div class="request-details-content">
                            <div class="request-details-content-box">
                                <p><i class="fa fa-tags"></i> Produto(s) - Informações</p>
                                <div class="tab-content padding">
                                    @php
                                        $productsGroupedBySupplier = $request->purchaseRequestProduct->groupBy(function ($item) {
                                            return $item->supplier->id;
                                        });
                                    @endphp

                                    @foreach ($productsGroupedBySupplier as $supplierIndex => $supplierGroup)
                                        <div class="request-supplier-group">
                                            <div class="request-details-content-box-supplier">
                                                <h4><strong>Fornecedor nº: {{$supplierIndex}}</strong></h4>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <p>Razão social: {{$supplierGroup->first()->supplier->corporate_name}}</p>
                                                        <p>Nome fantasia: {{$supplierGroup->first()->supplier->name}}</p>
                                                        <p>CNPJ/CPF: {{$supplierGroup->first()->supplier->cpf_cnpj}}</p>
                                                        <p>Tipo de pessoa: {{$supplierGroup->first()->supplier->entity_type}}</p>
                                                        <p>Indicação do fornecedor: {{$supplierGroup->first()->supplier->supplier_indication}}</p>
                                                        <p>Tipo de mercado: {{$supplierGroup->first()->supplier->market_type}}</p>
                                                        <p>Qualificação: {{$supplierGroup->first()->supplier->qualification->label()}}</p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <p>Representante: {{$supplierGroup->first()->supplier->representative}}</p>
                                                        <p>E-mail: {{$supplierGroup->first()->supplier->email}}</p>
                                                        <p>Registro estadual: {{$supplierGroup->first()->supplier->state_registration}}</p>
                                                        <p>Descrição: {{$supplierGroup->first()->supplier->description}}</p>
                                                        <hr>
                                                        <p>Fornecedor criado em: {{$supplierGroup->first()->supplier->created_at}}</p>
                                                        <p>Fornecedor atualizado em: {{$supplierGroup->first()->supplier->updated_at}}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="request-details-content-box-products">
                                                @foreach ($supplierGroup as $index => $productItem)
                                                    <div class="request-details-content-box-products-product">
                                                        <p>Produto nº {{$index}}:</p>
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <p>Identificação do produto nº: {{$productItem->id}}</p>
                                                                <p>Nome do produto: {{$productItem->name}}</p>
                                                                <p>Quantidade: {{$productItem->quantity}}</p>
                                                                <p>Preço unitário: {{$productItem->unit_price ?? '---'}}</p>
                                                                <p>Preço total: {{$productItem->unit_price ? ($productItem->unit_price * $productItem->quantity) : 'Indefinido'}}</p>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <p>Modelo do produto: {{$productItem->model ?? '---'}}</p>
                                                                <p>Cor do produto: {{$productItem->color ?? '---'}}</p>
                                                                <p>Tamanho e dimensões do produto: {{$productItem->size ?? '---'}}</p>
                                                                <p>Categoria: {{$productItem->category->name}}</p>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <p>Descrição do produto: {{$productItem->description ?? '---'}}</p>
                                                                <hr>
                                                                <p>Produto criado em: {{ \Carbon\Carbon::parse($productItem->created_at)->format('d/m/Y h:m:s') }}</p>
                                                                <p>Produto atualizado em: {{ \Carbon\Carbon::parse($productItem->updated_at)->format('d/m/Y h:m:s') }}</p>
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
