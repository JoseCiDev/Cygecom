<div class="modal fade" id="modal-supplier-register" tabindex="-1" role="dialog" aria-labelledby="modal-label"
    aria-hidden="true" style="z-index: 99999">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document" style="max-width: 1100px; width: 100%">
        <div class="modal-content" style="padding: 20px">
            <div class="modal-header row">
                <div class="col-sm-6">
                    <h4 class="modal-title" id="modal-label">Registrar novo fornecedor</h4>
                </div>
                <div class="col-sm-6">
                    <button type="button" class="btn btn-secondary btn-small pull-right" data-dismiss="modal" data-cy="btn-dismiss-modal">
                        Fechar
                    </button>
                </div>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <x-SupplierForm isAPI />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
