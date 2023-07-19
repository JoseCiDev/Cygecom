<div class="modal fade" id="modal-edit-installment" tabindex="-1" role="dialog" aria-labelledby="modal-label"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modal-label">Editar Parcela<strong class="name"></strong></h4>
            </div>
            <form id="form-modal-edit-installment" class="form-validate">
                <div class="modal-body">
                    <div class="row">
                        {{-- VENCIMENTO --}}
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="edit-expire-date" class="control-label">Vencimento</label>
                                <input
                                    type="date" name="expire_date"
                                    id="edit-expire-date" class="form-control edit-expire-date">
                            </div>
                        </div>
                        {{-- VALOR --}}
                        <div class="col-md-4">
                            <label for="edit-value" class="control-label">Valor
                            </label>
                            <div class="input-group">
                                <span class="input-group-addon">R$</span>
                                <input type="number" placeholder="0.00" class="form-control" min="0"
                                    name="value" id="edit-value">
                            </div>
                        </div>
                        {{-- STATUS --}}
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="edit-status" class="control-label">Status</label>
                                <select name="status" id="edit-status" class='select2-me'
                                    style="width:100%; padding-top:2px;" data-placeholder="Pagamento do serviço">
                                    <option value=""></option>
                                    @foreach($statusValues as $status)
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
                                <textarea required name="observation" id="edit-observation" rows="3"
                                    placeholder="Ex: Pago com atraso de 3 dias devido a xpto" class="form-control text-area no-resize"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary btn-edit-installment">
                        Salvar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

