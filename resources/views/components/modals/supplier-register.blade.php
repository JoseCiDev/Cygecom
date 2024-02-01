<div class="modal fade" id="modal-supplier-register" tabindex="-1" aria-labelledby="modal-supplier-register-label" aria-hidden="true" style="z-index: 99999">
    <div class="modal-dialog modal-xl">
        <div class="modal-content" style="padding: 20px">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modal-supplier-register-label">Cadastrar fornecedor</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        @can('post.api.suppliers.register')
                            <x-SupplierForm isAPI />
                        @else
                            Desculpe, você não possui autorização para cadastrar fornecedores.
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
