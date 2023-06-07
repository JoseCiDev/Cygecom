<a id="last-quote-requests-show" href="#" class="btn btn  btn-large pull-right">Últimas solicitações <i class="fa fa-magic"></i></a>

<div id="last-quote-requests" class="last-quote-requests-close">
    <div class="box">
        <div class="box-title">
            <h3>Últimas solicitações</h3>
            <div class="actions">
                <a id="last-quote-requests-hidden" href="#" class="btn btn-mini"> <i class="fa fa-times"></i></a>
            </div>
        </div>

        <div class="box-content">
            <div class="panel-group" id="accordion-quote-request">

                @foreach ($lastQuoteRequests as $key => $item)
                    <div class="panel panel-default">

                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a href="#accordion-quote-request-{{$key}}" data-toggle="collapse" data-parent="#accordion-quote-request">
                                    Solicitação de compra : #{{$item->id}}
                                </a>
                            </h4>
                        </div>

                        <div id="accordion-quote-request-{{$key}}" class="panel-collapse collapse">
                            <div class="panel-body">
                                <ul>
                                    <li>É COMEX: {{$item->is_comex ? 'Sim' : 'Não'}}</li>
                                    <li>Solicitado: {{$item->is_service ? 'Serviço(s)' : 'Produto(s)'}}</li>
                                    <li>Destino: {{$item->local_description}}</li>
                                    <li>Data desejada: {{$item->desired_date}}</li>
                                    <li>Cota será feito por: {{$item->is_supplies_quote ? 'Suprimentos' : 'Pessoal'}}</li>
                                    <li>Link: {{$item->quote_request_file}}</li>
                                </ul>
                                <button class="btn btn-primary">Copiar campos</button>
                            </div>
                        </div>

                    </div>
                @endforeach

            </div>
        </div>

    </div>
</div>

<style>
#last-quote-requests-show{
    margin-right: 15px;
    border-radius: 2px;
}

#last-quote-requests-show i{
    font-size: 18px
}

#last-quote-requests {
    position: fixed;
    top: 32vh;
    right: 0;
    z-index: 2;
    animation: sidebar-animation 0.5s;
    background-color: #ffffff;
    padding: 5px;
    width: 380px;
    box-shadow: 0 0 5px rgb(49, 112, 143);
}

@keyframes sidebar-animation {
    from {
        transform: translateX(100%);
    }
    to {
        transform: translateX(0);
    }
}

#last-quote-requests .box-title{
    margin-top: 0;
}

</style>

<script>
    $(document).ready(function() {
        $("#last-quote-requests-hidden").click(function(event) {
            $("#last-quote-requests").hide()
        });

        $("#last-quote-requests-show").click(function(event) {
            $("#last-quote-requests").show()
        });
    });
</script>

