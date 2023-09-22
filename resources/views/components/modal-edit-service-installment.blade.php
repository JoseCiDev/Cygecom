<div class="modal fade" id="modal-edit-service-installment" tabindex="-1" role="dialog" aria-labelledby="modal-label"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modal-label">Editar Parcela<strong class="name"></strong></h4>
            </div>
            <form id="form-modal-edit-service-installment" data-cy="form-modal-edit-service-installment" class="form-validate">
                <div class="modal-body">
                    <div class="row">
                        {{-- VENCIMENTO --}}
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="edit-expire-date" class="control-label">Vencimento</label>
                                <input type="date" name="expire_date" id="edit-expire-date" data-cy="edit-expire-date"
                                    class="form-control edit-expire-date">
                            </div>
                        </div>
                        {{-- VALOR --}}
                        <div class="col-md-4">
                            <label for="edit-value" class="control-label">Valor
                            </label>
                            <div class="input-group">
                                <span class="input-group-addon">R$</span>
                                <input type="text" placeholder="0.00" class="form-control" id="edit-value" data-cy="edit-value">
                                <input type="hidden" name="value" class="no-validation" id="edit-value-hidden" data-cy="edit-value-hidden">
                            </div>
                        </div>
                        {{-- STATUS --}}
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="edit-status" class="control-label">Status</label>
                                <select name="status" id="edit-status" data-cy="edit-status" class='select2-me'
                                    style="width:100%; padding-top:2px;" data-placeholder="Pagamento do serviço">
                                    <option value=""></option>
                                    @foreach ($statusValues as $status)
                                        <option value="{{ $status['id'] }}">{{ $status['description'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        {{-- OBS --}}
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="edit-observation" class="control-label">Observação</label>
                                <textarea name="observation" id="edit-observation" data-cy="edit-observation" rows="3"
                                    placeholder="Ex: Pago com atraso de 3 dias devido a xpto" class="form-control text-area no-resize"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-small" data-dismiss="modal" data-cy="btn-edit-observation-cancel">
                        Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary btn-small btn-edit-installment" data-cy="btn-edit-observation-submit">
                        Salvar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
