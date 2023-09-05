@php
    use App\Enums\{PurchaseRequestStatus, PurchaseRequestType};
@endphp
<x-app>
    <x-modalDelete/>

    <div class="row">
        <div class="col-sm-12">
            <div class="box box-color box-bordered">
                <div class="row" style="margin: 0 0 30px">
                    <div class="col-md-6" style="padding: 0">
                        <h1 class="page-title">Solicitações de Compra/Serviço</h1>
                    </div>
                    <div class="col-md-6" style="padding: 0">
                        <a data-cy="btn-nova-solicitacao" href="{{ route('request.links') }}" class="btn btn-primary btn-large pull-right">Nova Solicitação</a>
                    </div>
                </div>

               <div class="row">
                    <div class="col-md-12">
                        <div class="box-content nopadding regular-text">

                            <table
                                class="table table-hover table-nomargin table-bordered dataTable"
                                data-column_filter_dateformat="dd-mm-yy" data-nosort="0" data-checkall="all">
                                <thead>
                                    <tr>
                                        <th>Nº</th>
                                        <th>Solicitante</th>
                                        <th>Contratação por</th>
                                        <th>Tipo de solicitação</th>
                                        <th>Fornecedor(es)</th>
                                        <th>Status</th>
                                        <th>Responsável</th>
                                        <th>Data desejada</th>
                                        <th>Atualizado em</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($purchaseRequests as $index => $purchaseRequest)
                                        @php
                                            $isDraft = $purchaseRequest->status->value === PurchaseRequestStatus::RASCUNHO->value;
                                            $supplier = null;
                                            $msg = '';
                                            if ($purchaseRequest->type === PurchaseRequestType::SERVICE) {
                                                $supplier = $purchaseRequest->service->supplier ?? null;
                                            } elseif ($purchaseRequest->type === PurchaseRequestType::CONTRACT) {
                                                $supplier = $purchaseRequest->contract->supplier ?? null;
                                            } else  {
                                                $countSuppliers = count($purchaseRequest?->purchaseRequestProduct?->groupBy('supplier_id'));

                                                if ($countSuppliers > 1) {
                                                    $msg = ' (+' . ($countSuppliers -1) . ')';
                                                }
                                                $supplier = $purchaseRequest?->purchaseRequestProduct->first()->supplier ?? null;
                                            }
                                        @endphp
                                        <tr>
                                            <td>{{$purchaseRequest->id}}</td>
                                            <td>{{$purchaseRequest->user->person->name}}</td>
                                            <td>{{$purchaseRequest->is_supplies_contract ? 'Suprimentos' : 'Área Solicitante'}}</td>
                                            <td>{{$purchaseRequest->type->label()}}</td>
                                            <td>{{$supplier?->corporate_name . $msg}}</td>
                                            <td>{{$purchaseRequest->status->label()}}</td>
                                            <td>{{$purchaseRequest->suppliesUser?->person?->name}}</td>
                                            <td>{{ \Carbon\Carbon::parse($purchaseRequest->desired_date)->format('d/m/Y') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($purchaseRequest->updated_at)->format('d/m/Y h:m:s') }}</td>

                                            {{-- BTN AÇÕES --}}
                                            <td style="white-space: nowrap;">
                                                <a href="{{route('request.edit', ['type'=> $purchaseRequest->type, 'id' => $purchaseRequest->id])}}"
                                                    class="btn"
                                                    rel="tooltip"
                                                    title="{{$isDraft ? 'Editar' : 'Visualizar'}}"
                                                    data-cy="btn-edit-request-{{$index}}"
                                                >
                                                    @if($isDraft)
                                                        <i class="fa fa-edit"></i>
                                                    @else
                                                        <i class="fa fa-eye"></i>
                                                    @endif
                                                </a>
                                                @php
                                                    $endpoint = $purchaseRequest->type->value;
                                                    $route = "request.$endpoint.register";
                                                @endphp
                                                <a href="{{route($route, ['id' => $purchaseRequest->id])}}"
                                                    rel="tooltip"
                                                    title="Copiar"
                                                    class="btn"
                                                    data-cy="btn-copy-request-{{$index}}"
                                                >
                                                    <i class="fa fa fa-copy"></i>
                                                </a>
                                                @if($purchaseRequest->status->value === PurchaseRequestStatus::RASCUNHO->value)
                                                    <button data-route="purchaseRequests"
                                                        data-name="{{'Solicitação de compra - Nº ' . $purchaseRequest->id}}"
                                                        data-id="{{$purchaseRequest->id}}"
                                                        rel="tooltip"
                                                        title="Excluir"
                                                        class="btn"
                                                        data-toggle="modal"
                                                        data-target="#modal"
                                                        data-cy="btn-delete-request-{{$index}}"
                                                    >
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
               </div>
            </div>
        </div>
    </div>

</x-app>
