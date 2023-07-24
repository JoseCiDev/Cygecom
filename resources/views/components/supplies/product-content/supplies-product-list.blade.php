<div class="row">
    <div class="col-sm-12">
        <div class="box box-color box-bordered">

            <div class="box-title">
                <div class="row">
                    <div class="col-md-6">
                        <h3 class="pull-left">Solicitações de Produtos</h3>
                    </div>
                </div>
            </div>

            <div class="box-content nopadding">

                <table
                    class="table table-hover table-nomargin table-bordered dataTable"
                    data-column_filter_dateformat="dd-mm-yy" data-nosort="0" data-checkall="all">
                    <thead>
                        <tr>
                            <th class="col-sm-1">ID</th>
                            <th class="col-sm-1">Solicitante</th>
                            <th class="col-sm-1">Fornecedor</th>
                            <th class="col-sm-1">Qualif. fornecedor</th>

                            <th class="col-sm-1">Tipo de quitação</th>
                            <th class="col-sm-1">Progresso</th>
                            <th class="col-sm-1">Contratação por</th>
                            <th class="col-sm-1">Grupo de custo</th>

                            <th class="col-sm-1">Data desejada</th>
                            <th class="col-sm-1">Atualizado em</th>

                            <th class="col-sm-1">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product),
                            @php 
                                $groups = $product->CostCenterApportionment->pluck('costCenter.Company.group')->unique(); 
                                $concatenatedGroups = $groups->map(function ($item) {
                                        return $item->label(); 
                                    })->implode(', ');
                            @endphp
                            <tr>
                                <td>{{$product->id}}</td>
                                <td>{{$product->user->person->name}}</td>
                                <td>{{$product->purchaseRequestProduct->first()->Supplier->cpf_cnpj}}</td>
                                <td>{{$product->purchaseRequestProduct->first()->Supplier->qualification->label()}}</td>

                                <td>{{$product->purchaseRequestProduct->first()->is_prepaid ? 'Pgto. Antecipado' : 'Pgto. pós-pago'}}</td>
                                <td>{{$product->purchaseRequestProduct->first()->already_provided ? 'Executado' : 'Não executado'}}</td>
                                <td>{{$product->is_supplies_quote ? 'Suprimentos' : 'Solicitante'}}</td>
                                <td>{{$concatenatedGroups}}</td>

                                <td>{{ $product->desired_date ? \Carbon\Carbon::parse($product->desired_date)->format('d/m/Y h:m:s') : '---'}}</td>
                                <td>{{ $product->updated_at ? \Carbon\Carbon::parse($product->updated_at)->format('d/m/Y h:m:s') : '---'}}</td>

                                {{-- BTN AÇÕES --}}
                                <td class="text-center" style="white-space: nowrap;">
                                    <button 
                                        data-modal-name="{{ 'Analisando Solicitação de Produto - ID ' . $product->id }}"
                                        data-id="{{ $product->id }}"
                                        data-request="{{json_encode($product)}}"
                                        rel="tooltip"
                                        title="Analisar"
                                        class="btn btn-primary"
                                        data-toggle="modal"
                                        data-target="#modal-supplies"
                                    >
                                        <i class="fa fa-search"></i> Analisar
                                    </button>
                                    <a href="{{route('supplies.product.detail', ['id' => $product->id])}}"
                                        class="btn btn-link"
                                        rel="tooltip"
                                        title="Abrir"
                                    >
                                        <i class="fa fa-external-link"></i> Abrir
                                    </a>
                                    <a href="{{route('request.edit', ['type'=> $product->type, 'id' => $product->id])}}"
                                        class="btn"
                                        rel="tooltip"
                                        title="Editar"
                                    >
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    @php
                                        $endpoint = $product->type->value;
                                        $route = "request.$endpoint.register";
                                    @endphp
                                    <a href="{{route($route, ['id' => $product->id])}}"
                                        rel="tooltip"
                                        title="Copiar"
                                        class="btn"
                                    >
                                        <i class="fa fa fa-copy"></i>
                                    </a>
                                    <button data-route="purchaseRequests"
                                        data-name="{{'Solicitação de compra - ID ' . $product->id}}"
                                        data-id="{{$product->id}}"
                                        rel="tooltip"
                                        title="Excluir"
                                        class="btn btn-danger"
                                        data-toggle="modal"
                                        data-target="#modal"
                                    >
                                        <i class="fa fa-times"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
