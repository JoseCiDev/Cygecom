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
                            <th>ID</th>
                            <th>Solicitante</th>
                            <th>Responsável</th>
                            <th>Responsável em</th>
                            <th>Status</th>
                            <th>Tipo de quitação</th>
                            <th>Progresso</th>
                            <th>Contratação por</th>
                            <th>Grupo de custo</th>
                            <th>Data desejada</th>
                            <th>Atualizado em</th>
                            <th>Ações</th>
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
                                <td>{{$product->SuppliesUser?->Person->name ?? '---'}}</td>
                                <td>{{$product->responsibility_marked_at ? \Carbon\Carbon::parse($product->responsibility_marked_at)->format('d/m/Y h:m:s') : '---'}}</td>
                                <td>{{$product->status->label()}}</td>
                                <td>{{$product->purchaseRequestProduct->first()->is_prepaid ? 'Pgto. Antecipado' : 'Pgto. pós-pago'}}</td>
                                <td>{{$product->purchaseRequestProduct->first()->already_provided ? 'Executado' : 'Não executado'}}</td>
                                <td>{{$product->is_supplies_quote ? 'Suprimentos' : 'Solicitante'}}</td>
                                <td>{{$concatenatedGroups}}</td>

                                <td>{{ $product->desired_date ? \Carbon\Carbon::parse($product->desired_date)->format('d/m/Y h:m:s') : '---'}}</td>
                                <td>{{ $product->updated_at ? \Carbon\Carbon::parse($product->updated_at)->format('d/m/Y h:m:s') : '---'}}</td>

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
                                    @php $isToShow = !(bool)$product->SuppliesUser?->Person->name &&  !(bool)$product->responsibility_marked_at @endphp
                                    <a href="{{route('supplies.product.detail', ['id' => $product->id])}}"
                                        class="btn btn-link openDetail"
                                        rel="tooltip"
                                        title="Abrir"
                                        isToShow="{{$isToShow ? 'true' : 'false'}}"
                                    >
                                        <i class="fa fa-external-link"></i> Abrir
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="{{asset('js/modal-confirm-supplies-responsability/modal-confirm-supplies-responsability.js')}}"></script>
