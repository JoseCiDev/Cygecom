@php
    use App\Enums\SupplierQualificationStatus;

    $productRequests = $supplier->purchaseRequestProduct;
    $serviceRequests = $supplier->service;
    $contractRequests = $supplier->contract;
    $purchaseRequests = $productRequests->concat($serviceRequests)->concat($contractRequests);

    $isUnderAnalysis = $supplier->qualification->value === SupplierQualificationStatus::EM_ANALISE->value;
@endphp

<x-app>

    @if ($isUnderAnalysis && Gate::allows('gestor_fornecedores'))
        <x-supplier.purchase-requests :supplier="$supplier" :purchaseRequests="$purchaseRequests" />
    @endif

    <div class="row">
        <div class="col-sm-12">
            <div class="box box-color box-bordered">

                <div class="box-title">
                    <div class="row">
                        <div class="col-md-6">
                            <h3 class="pull-left">Editar fornecedor</h3>
                        </div>
                    </div>
                </div>

                <div class="box-content">
                    <x-SupplierForm :id="$id" :supplier="$supplier" />
                    <span>(<span style="color:red"><strong>*</strong></span>) É obrigatório</span>
                </div>
            </div>
        </div>
    </div>

</x-app>
