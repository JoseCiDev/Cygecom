@php
    if(isset($contract)) {
        $request = $contract;
    } else if(isset($product)) {
        $request = $product;
    } else if(isset($service)) {
        $request = $service;
    } else {
        $request = null;
    }
@endphp

<x-app>
    <x-slot name="title">
        <h1>Página de suprimentos</h1>
    </x-slot>

    <div class="request-details">
        <header class="request-details-header">
            <img class="request-details-header-logo" src="https://s3.amazonaws.com/gupy5/production/companies/32213/career/73435/images/2022-06-29_14-57_logo.jpg" alt="Logo Essentia Group">
            <h1>Solicitação de produto nº {{$request->id}}</h1>
            <div>
                <span>Criado em: {{ \Carbon\Carbon::parse($request->created_at)->format('d/m/Y h:m:s') }}</span> | <span>Atualizado: {{ \Carbon\Carbon::parse($request->updated_at)->format('d/m/Y h:m:s') }}</span>
            </div>
            <p>Desejado para: {{$request->desired_date ? \Carbon\Carbon::parse($request->desired_date)->format('d/m/Y') : "---"}}</p>
        </header>
        <main>
            <div class="row">
                <div class="col-sm-12">
                    <div class="box box-bordered">
                        <div class="box-title"> <h2 class="request-title">Detalhes da solicitação</h2> </div>
                        <div class="request-details-content">

                            <div class="request-details-content-box">
                                <p><i class="fa fa-info"></i> Informações básicas</p>
                                <hr>
                                <div class="tab-content padding">
                                    <p>Nº da solicitação: {{$request->id}}</p>
                                    <p>Nº do solicitante: {{$request->user_id}}</p>
                                    <p>Status de aprovação: {{$request->status->label()}}</p>
                                    <p>Tipo de solicitação: {{$request->type->label()}}</p>
                                    <p>Contratação deve ser por: {{$request->is_supplies_contract ? 'Suprimentos' : 'Centro de custo solicitante'}}</p>
                                    <p>COMEX: {{$request->is_comex ? 'Sim' : 'Não'}}</p>
                                    <p>Link de sugestão: 
                                        @if (count($request->PurchaseRequestFile) && $request->PurchaseRequestFile->first()->path) 
                                            <a href="{{$request->PurchaseRequestFile->first()->path}}" target="_blank" rel="noopener noreferrer">link</a>
                                        @else
                                        ---
                                        @endif
                                    </p>
                                    <label>Motivo da solicitação: 
                                        <textarea class="no-resize" style="display:block" readonly cols="70" rows="6">{{$request->reason}}</textarea>
                                    </label>
                                    <label>Observação: 
                                        <textarea class="no-resize" style="display:block" readonly cols="70" rows="6">{{$request->observation}}</textarea>
                                    </label>
                                    <hr>
                                    <p>Solicitação criada em: {{ \Carbon\Carbon::parse($request->created_at)->format('d/m/Y h:m:s') }}</p> 
                                    <p>Solicitação atualizada em: {{ \Carbon\Carbon::parse($request->updated_at)->format('d/m/Y h:m:s') }}</p>
                                    <p>Solicitação desejada para: {{$request->desired_date ? \Carbon\Carbon::parse($request->desired_date)->format('d/m/Y') : "---"}}</p>
                                </div>
                            </div>

                            <div class="request-details-content-box">
                                <p><i class="fa fa-user"></i> Informações do solicitante</p>
                                <hr>
                                <div class="tab-content padding">
                                    <p>Nº do solicitante: {{$request->user_id}}</p>
                                    <p>E-mail do solicitante: {{$request->user->email}}</p>
                                    <p>Nome do solicitante: {{$request->user->person->name}}</p>
                                    <p>Documento do solicitante: {{$request->user->person->cpf_cnpj}}</p>
                                    <p>Celular/Telefone: {{$request->user->person->phone->number}}</p>
                                    <p>Centro de custo do solicitante: {{$request->user->person->costCenter->name}}</p>
                                    <p>Empresa do centro de custo: {{$request->user->person->costCenter->company->corporate_name}}</p>
                                    <hr>
                                    <p>Perfil do solicitante: {{$request->user->Profile->name}}</p>
                                    <p>Autorização para solicitar: {{$request->user->is_buyer ? 'Autorizado' : 'Sem autorização'}}</p>
                                    <p>Aprovação limite: {{$request->user->approver_limit ?? 'Sem limite'}}</p>
                                    <p>Nº do aprovador: {{$request->user->approver_user_id ?? 'Sem aprovador'}}</p>
                                    <hr>
                                    <p>Usuário criado em: {{ \Carbon\Carbon::parse($request->user->created_at)->format('d/m/Y h:m:s') }}</p> 
                                    <p>Usuário atualizado em: {{ \Carbon\Carbon::parse($request->user->updated_at)->format('d/m/Y h:m:s') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="request-details-content">
                            <div class="request-details-content-box">
                                <p><i class="fa fa-money"></i> Centro de custo e rateio</p>
                                <hr>
                                <div class="tab-content padding">
                                    <p>Qtd. de centro de custos: {{$request->costCenterApportionment->count()}}</p>

                                    <div class="request-details-content-box-apportionment">
                                        @foreach ($request->costCenterApportionment as $index => $apportionment)
                                        <div>
                                            <p>Centro de custo nº {{$index}}</p>
                                            <ul>
                                                <p>Porcentagem (%): {{$apportionment->apportionment_percentage ?? '---'}}</p>
                                                <p>Custo (R$): {{$apportionment->apportionment_currency ?? '---'}}</p>
                                                <p>Centro de custo: {{$apportionment->costCenter->name}}</p>
                                                <p>Empresa: {{$apportionment->costCenter->company->corporate_name}}</p>
                                                <p>CNPJ: {{$apportionment->costCenter->company->cnpj}}</p>
                                            </ul>
                                        </div>
                                        @endforeach
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                        
                        <div class="request-details-content">
                            <div class="request-details-content-box">
                                <p><i class="fa fa-tags"></i> Contrato - Informações</p>
                                <div class="tab-content padding">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <p>Contrato nº: {{$request->contract->id}}</p>
                                            <p>Nome do contrato: {{$request->contract->name}}</p>
                                            <p>Status do contrato: {{$request->contract->is_active ? 'Ativo' : 'Inativo' }}</p>
                                            <hr>
                                            <p>Recorrência do pagamento: {{$request->contract->recurrence}}</p>
                                            <p>Flexibilidade do pagamento: Pgto. {{$request->contract->is_fixed_payment ? 'fixo' : 'variável'}}</p>
                                            <p>Tipo de quitação: Pgto. {{$request->contract->is_prepaid ? 'antecipado' : 'pós-pago'}}</p>
                                            <p>Local do serviço: {{$request->contract->local_service}}</p>
                                            <p>Valor total do contrato: {{$request->contract->total_ammount}}</p>
                                            <p>Qtd. de parcelas: {{$request->contract->quantity_of_installments}}</p>
                                        </div>
                                        <div class="col-md-4">
                                            <p>Razão social: {{$request->contract->supplier->corporate_name}}</p>
                                            <p>Nome fantasia: {{$request->contract->supplier->name}}</p>
                                            <p>CNPJ/CPF: {{$request->contract->supplier->cpf_cnpj}}</p>
                                            <p>Tipo de pessoa: {{$request->contract->supplier->entity_type}}</p>
                                            <p>Indicação do fornecedor: {{$request->contract->supplier->supplier_indication}}</p>
                                            <p>Tipo de mercado: {{$request->contract->supplier->market_type}}</p>
                                            <p>Qualificação: {{$request->contract->supplier->qualification->label()}}</p>
                                            <hr>
                                            <p>Representante: {{$request->contract->supplier->representative}}</p>
                                            <p>E-mail: {{$request->contract->supplier->email}}</p>
                                            <p>Registro estadual: {{$request->contract->supplier->state_registration ?? '---'}}</p>
                                            <p>Descrição do fornecedor: {{$request->contract->supplier->description}}</p>
                                        </div>
                                        <div class="col-md-4">
                                            <p>Dia de pagamento: {{Carbon\Carbon::parse($request->contract->payday)->format('d/m/Y')}}</p>
                                            <p>Vigência - Dia de início: {{$request->contract->start_date ? Carbon\Carbon::parse($request->contract->start_date)->format('d/m/Y') : '---'}}</p>
                                            <p>Vigência - Dia de fim: {{$request->contract->end_date ? Carbon\Carbon::parse($request->contract->end_date)->format('d/m/Y') : '---'}}</p>
                                            <p>Contrato criado em: {{Carbon\Carbon::parse($request->contract->created_at)->format('d/m/Y')}}</p>
                                            <p>Contrato atualizado em: {{Carbon\Carbon::parse($request->contract->updated_at)->format('d/m/Y')}}</p>
                                            <p>Fornecedor criado em: {{$request->contract->supplier->created_at}}</p>
                                            <p>Fornecedor atualizado em: {{$request->contract->supplier->updated_at}}</p>
                                            <hr>
                                            <label>Descrição: 
                                                <textarea class="no-resize" style="display:block" readonly cols="70" rows="6">{{$request->contract->descrilabeltion}}</textarea>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="request-details-content-box-contract">
                                        @foreach ($request->contract->installments as $installmentIndex => $installment)
                                            <div class="request-details-content-box-contract-installment">
                                                <p>Parcela nº: {{$installmentIndex + 1}}</p>
                                                <p>Valor: {{$installment->value}}</p>
                                                <p>Pago no dia: {{$installment->payment_day ?? '---'}}</p>
                                                <p>Descrição do pagamento:</p>
                                                <span>{{$installment->description ?? '---'}}</span>
                                            </div>
                                        @endforeach
                                    </div>

                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </main>
    </div>
</x-app>
