<div class="modal fade" id="modal-supplier-register" tabindex="-1" role="dialog" aria-labelledby="modal-label"
    aria-hidden="true" style="z-index: 99999">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="padding: 20px">
            <div class="modal-header">
                <h4 class="modal-title" id="modal-label">Registrar novo fornecedor</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <x-SupplierForm isAPI />
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" data-cy="btn-dismiss-modal">
                    Fechar
                </button>
            </div>
        </div>
    </div>
</div>
