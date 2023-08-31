<div class="modal fade" id="modal-add-installment" tabindex="-1" role="dialog" aria-labelledby="modal-label"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modal-label">Adicionar Parcela<strong class="name"></strong></h4>
            </div>
            <form id="form-modal-add-installment" data-cy="form-modal-add-installment" class="form-validate">
                <div class="modal-body">
                    <div class="row">
                        {{-- VENCIMENTO --}}
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="expire-date" class="control-label">Vencimento</label>
                                <input
                                    type="date" name="expire_date"
                                    id="expire-date" data-cy="expire-date" class="form-control expire-date"
                                    data-rule-required="true">
                            </div>
                        </div>
                        {{-- VALOR --}}
                        <div class="col-md-4">
                            <label for="value" class="control-label">Valor</label>
                            <div class="input-group">
                                <span class="input-group-addon">R$</span>
                                <input type="text" placeholder="0.00" class="form-control" id="value" data-cy="value">
                                <input type="hidden" name="value" id="value-hidden" data-cy="value-hidden">
                            </div>
                        </div>
                        {{-- STATUS --}}
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="status" class="control-label">Status</label>
                                <select name="status" id="status" data-cy="status" class='select2-me'
                                    style="width:100%; padding-top:2px;" data-placeholder="Pagamento do serviço"
                                    data-rule-required="true">
                                    <option value=""></option>
                                    <option value="1">PAGO</option>
                                    <option value="3">EM ATRASO</option>
                                    <option value="4">PENDENTE</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        {{-- OBS --}}
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="observation" class="control-label">Observação</label>
                                <textarea name="observation" id="observation" data-cy="observation" rows="3"
                                    placeholder="Ex: Pago com atraso de 3 dias devido a xpto" class="form-control text-area no-resize"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-small" data-dismiss="modal" data-cy="btn-cancel-installment">
                        Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary btn-small btn-save-installment" data-cy="btn-submit-installment">
                        Salvar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
