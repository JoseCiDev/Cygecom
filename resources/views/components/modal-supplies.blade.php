<div class="modal fade" id="modal-supplies" tabindex="-1" role="dialog" aria-labelledby="modal-label" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-label">
                    <strong class="modal-name"></strong>
                </h3>
            </div>
            <div class="modal-body">
                <h4>Aqui consta informações básicas da solicitação:</h4>
                <div class="request-details-content">
                    <div class="request-details-content-box">
                        <div class="tab-content padding">
                            <h4><i class="fa fa-info"></i> <strong>Informações básicas</strong></h4>
                            <hr>
                            <p>
                                <strong>Status de aprovação:</strong> <span class="status"></span>
                            </p>
                            <p>
                                <strong>Tipo de solicitação:</strong> <span class="type"></span>
                            </p>
                            <p>
                                <strong>Contratação deve ser por:</strong>
                                <span class="is_supplies_contract"></span>
                            </p>
                            <p>
                                <strong>COMEX:</strong> <span class="is_comex"></span>
                            </p>
                            <p>
                                <strong>Link de sugestão:</strong>
                                <span class="purchase_request_file"></span>
                            </p>
                            <p>
                                <strong>Solicitação criada em:</strong> <span class="created_at"></span>
                            </p>
                            <p>
                                <strong>Solicitação atualizada em:</strong> <span class="updated_at"></span>
                            </p>
                            <p>
                                <strong>Solicitação desejada para:</strong> <span class="desired_date"></span>
                            </p>
                            <hr>
                            <h4><i class="fa fa-user"></i> <strong>Informações do solicitante</strong></h4>
                            <hr>
                            <p><strong>E-mail do solicitante:</strong> <span class="user-email">---</span></p>
                            <p>
                                <strong>Autorização para solicitar:</strong>
                                <span class="user-is_buyer">---</span>
                            </p>
                            <p>
                                <strong>Aprovação limite:</strong>
                                <span class="user-approve_limit">---</span>
                            </p>
                        </div>
                    </div>
                    <div class="request-details-content-box">
                        <div class="tab-content padding">
                            <h4><i class="fa fa-user"></i> <strong>Informações do suprimentos</strong></h4>
                            <hr>
                            <p>
                                <strong>Responsável:</strong> <span class="supplies-user-email">---</span>
                            </p>
                            <p>
                                <strong>E-mail do responsável:</strong> <span class="supplies-user-person">---</span>
                            </p>
                            <p>
                                <strong>Responsável em:</strong> <span class="responsibility_marked_at">---</span>
                            </p>
                            <hr>
                            <h4><i class="fa fa-user"></i> <strong>Motivo e observações</strong></h4>
                            <hr>
                            <p>
                                <strong>Motivo da solicitação:</strong> <span class="reason"></span>
                            </p>
                            <p>
                                <strong>Observação:</strong> <span class="observation"></span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

<script src="{{asset('js/modal-supplies/show-modal-and-set-mapped-content.js')}}"></script>
