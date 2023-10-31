
<style>
    .topic {
        padding-bottom: 15px;
    }
</style>

<div class="modal fade" id="modal-supplies" tabindex="-1" role="dialog" aria-labelledby="modal-label" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modal-label">
                    <strong class="modal-name"></strong>
                </h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h4>Aqui consta informações básicas da solicitação:</h4>
                <div class="request-details-content">

                    <div class="request-details-content-box">

                        <div class="tab-content padding">
                            {{-- INFO BASICA --}}
                            <h4 class="topic"><i class="fa fa-info"></i> <strong>Informações básicas</strong></h4>
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
                                <strong>Solicitação criada em:</strong> <span class="created_at"></span>
                            </p>
                            <p>
                                <strong>Solicitação atualizada em:</strong> <span class="updated_at"></span>
                            </p>
                            <p>
                                <strong>Solicitação desejada para:</strong> <span class="desired_date"></span>
                            </p>

                            <hr>

                            {{-- SOLICITANTE --}}
                            <h4 class="topic"><i class="fa fa-user"></i> <strong>Informações do solicitante</strong></h4>
                            <p><strong>E-mail do solicitante:</strong> <span class="user-email">---</span></p>
                            <p>
                                <strong>Autorização para solicitar:</strong>
                                <span class="user-is_buyer">---</span>
                            </p>

                        </div>

                    </div>

                    <div class="request-details-content-box">
                        <div class="tab-content padding">
                            {{-- FORNECEDORES --}}
                            <h4 class="topic"><i class="glyphicon glyphicon-briefcase"></i> <strong>Fornecedores</strong></h4>
                            <div class="supplier-information" style="font-size: 16px">
                                {{-- Adição dinâmica de fornecedores--}}
                            </div>

                            {{-- SUPRIMENTOS --}}
                            <h4 class="topic"><i class="fa fa-user"></i> <strong>Informações do suprimentos</strong></h4>
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

                            {{-- CENTRO DE CUSTO --}}
                            <h4 class="topic"><i class="fa-solid fa-money-bill"></i> <strong>Centros de custo</strong></h4>
                            <ul class="costCenterApportionment" style="font-size: 16px">
                                {{-- Adição dinâmica de <li> aqui --}}
                            </ul>

                        </div>
                    </div>

                    <div class="request-details-content-box">
                        <div class="tab-content padding">

                            {{-- LINKS --}}
                            <h4 class="topic"><i class="glyphicon glyphicon-globe"></i> <strong>Links de apoio/sugestão</strong></h4>
                            <p class="support_links" style="white-space: pre-wrap; max-height: 300px; overflow:scroll;"></p>
                            <hr>

                            {{-- PRODUTOS --}}
                            <div class="modal-list-container">
                                <h4 class="topic"><i class="glyphicon glyphicon--sign"></i> <strong>Produtos</strong></h4>
                                <ul id="modal-product-list">
                                    {{-- Adição dinâmica de <li> aqui --}}
                                </ul>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script type="module" src="{{asset('js/supplies/show-modal-and-set-mapped-content.js')}}"></script>
@endpush
