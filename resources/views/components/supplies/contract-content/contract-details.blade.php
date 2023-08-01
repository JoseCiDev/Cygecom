@php
    if (isset($contract)) {
        $request = $contract;
    } elseif (isset($product)) {
        $request = $product;
    } elseif (isset($service)) {
        $request = $service;
    } else {
        $request = null;
    }

    $requestIsFromLogged = $request->user_id === auth()->user()->id;
@endphp

<x-app>
    <x-slot name="title">
        <h1>Página de suprimentos</h1>
    </x-slot>

    <div class="row">
        <div class="col-sm-12">
            <form data-cy="form-request-status" class="form-validate" method="POST" action="{{ route('supplies.request.status.update', ['id' => $request->id]) }}">
            @csrf
                <div class="row">
                   <div class="col-md-6">
                        <label for="status">Status da solicitação</label>
                   </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <select name="status" data-cy="status" @disabled($requestIsFromLogged)>
                            @foreach ($allRequestStatus as $status)
                                @if ($status->value !== \App\Enums\PurchaseRequestStatus::RASCUNHO->value);
                                    <option @selected($request->status === $status) value="{{$status}}">{{$status->label()}}</option>
                                @endif
                            @endforeach
                        </select>
                        <button data-cy="btn-apply-status" type="submit" class="btn btn-icon btn-small btn-primary" @disabled($requestIsFromLogged)> Aplicar status </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
  
    <div class="row">
        <div class="col-md-12">
            <div class="pull-right">
                <x-PdfGeneratorButton print-by-selector=".details-content" :file-name="'solicitacao_contrato_'.$request->id . now()->format('dmY_His_u')"/>
            </div>
        </div>
    </div>

    <div class="request-details">
        <div class="details-content">
            <header class="request-details-header">
                <img class="request-details-header-logo"
                    src="https://s3.amazonaws.com/gupy5/production/companies/32213/career/73435/images/2022-06-29_14-57_logo.jpg"
                    alt="Logo Essentia Group">
                <h1>Solicitação de produto nº {{ $request->id }}</h1>
                <div>
                    <span>Criado em: {{ \Carbon\Carbon::parse($request->created_at)->format('d/m/Y h:m:s') }}</span> |
                    <span>Atualizado: {{ \Carbon\Carbon::parse($request->updated_at)->format('d/m/Y h:m:s') }}</span>
                </div>
                <p>Produto(s) desejado(s) para:
                    {{ $request->desired_date ? \Carbon\Carbon::parse($request->desired_date)->format('d/m/Y') : '---' }}
                </p>
                <div class="row">
                    <div class="col-md-12">
                        <h4>Responsável pela solicitação: {{$request->SuppliesUser?->Person->name ?? '---'}} / {{$request->SuppliesUser?->email ?? "---"}}</h4>
                    </div>
               </div>
            </header>
            <main>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="box box-bordered">
                            <div class="box-title">
                                <h2 class="request-title">Detalhes da solicitação</h2>
                            </div>
                            <div class="request-details-content">

                                <div class="request-details-content-box">
                                    <h4><i class="fa fa-info"></i> <strong>Informações básicas</strong></h4>
                                    <hr>
                                    <div class="tab-content padding">
                                        <p><strong>Status de aprovação:</strong> {{ $request->status->label() }}</p>
                                        <p><strong>Tipo de solicitação:</strong> {{ $request->type->label() }}</p>
                                        <p><strong>Contratação deve ser por:</strong>
                                            {{ $request->is_supplies_contract ? 'Suprimentos' : 'Centro de custo solicitante' }}
                                        </p>
                                        <p><strong>COMEX:</strong> {{ $request->is_comex ? 'Sim' : 'Não' }}</p>
                                        <p>
                                            <strong>Motivo da solicitação:</strong> {{ $request->reason }}
                                        </p>
                                        <p>
                                            <strong>Observação:</strong> {{ $request->observation }}
                                        </p>
                                        <hr>
                                        <p>
                                            <strong>Solicitação criada em:</strong>
                                            {{ \Carbon\Carbon::parse($request->created_at)->format('d/m/Y h:m:s') }}
                                        </p>
                                        <p>
                                            <strong>Solicitação atualizada em:</strong>
                                            {{ \Carbon\Carbon::parse($request->updated_at)->format('d/m/Y h:m:s') }}
                                        </p>
                                        <p>
                                            <strong>Solicitação desejada para:</strong>
                                            {{ $request->desired_date ? \Carbon\Carbon::parse($request->desired_date)->format('d/m/Y') : '---' }}
                                        </p>
                                    </div>
                                </div>

                                <div class="request-details-content-box">
                                    <h4><i class="fa fa-user"></i> <strong>Informações do solicitante</strong></h4>
                                    <hr>
                                    <div class="tab-content padding">
                                        <p>
                                            <strong>E-mail do solicitante:</strong> {{ $request->user->email }}
                                        </p>
                                        <p>
                                            <strong>Nome do solicitante:</strong> {{ $request->user->person->name }}
                                        </p>
                                        <p>
                                            <strong>Documento do solicitante:</strong>
                                            {{ $request->user->person->cpf_cnpj }}
                                        </p>
                                        <p>
                                            <strong>Celular/Telefone:</strong> {{ $request->user->person->phone->number }}
                                        </p>
                                        <p>
                                            <strong>Centro de custo do solicitante:</strong>
                                            {{ $request->user->person->costCenter->name }}
                                        </p>
                                        <p>
                                            <strong>Empresa do centro de custo:</strong>
                                            {{ $request->user->person->costCenter->company->corporate_name }}
                                        </p>
                                        <hr>
                                        <p>
                                            <strong>Perfil do solicitante:</strong> {{ $request->user->Profile->name }}
                                        </p>
                                        <p>
                                            <strong>Autorização para solicitar:</strong>
                                            {{ $request->user->is_buyer ? 'Autorizado' : 'Sem autorização' }}
                                        </p>
                                        <p>
                                            <strong>Aprovação limite:</strong>
                                            {{ $request->user->approver_limit ?? 'Sem limite' }}
                                        </p>
                                        <p>
                                            <strong>Nº do aprovador:</strong>
                                            {{ $request->user->approver_user_id ?? 'Sem aprovador' }}
                                        </p>
                                        <hr>
                                        <p>
                                            <strong>Usuário criado em:</strong>
                                            {{ \Carbon\Carbon::parse($request->user->created_at)->format('d/m/Y h:m:s') }}
                                        </p>
                                        <p>
                                            <strong>Usuário atualizado em:</strong>
                                            {{ \Carbon\Carbon::parse($request->user->updated_at)->format('d/m/Y h:m:s') }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <hr class="pagebreak"/>
                            
                            <div class="request-details-content">
                                <div class="request-details-content-box">
                                    <h4><i class="fa fa-money"></i> <strong>Centro de custo e rateio</strong></h4>
                                    <hr>
                                    <div class="tab-content padding">
                                        <p>
                                            <strong>Qtd. de centro de custos:</strong>
                                            {{ $request->costCenterApportionment->count() }}
                                        </p>
                                        <div class="tab-content request-details-content-box-apportionment">
                                            @foreach ($request->costCenterApportionment as $index => $apportionment)
                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <p>
                                                            <strong>Porcentagem (%):</strong>
                                                            {{ $apportionment->apportionment_percentage ?? '---' }}
                                                        </p>
                                                        <p>
                                                            <strong>Custo (R$):</strong>
                                                            {{ $apportionment->apportionment_currency ?? '---' }}
                                                        </p>
                                                    </div>
                                                    <div class="col-sm-5">
                                                        <p>
                                                            <strong>Centro de custo:</strong>
                                                            {{ $apportionment->costCenter->name }}
                                                        </p>
                                                        <p>
                                                            <strong>CNPJ:</strong>
                                                            {{ $apportionment->costCenter->company->cnpj }}
                                                        </p>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <p>
                                                            <strong>Empresa:</strong>
                                                            {{ $apportionment->costCenter->company->corporate_name }}
                                                        </p>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="request-details-content">
                                <div class="request-details-content-box">
                                    <h4><i class="fa fa-truck"></i> <strong>Fornecedor</strong></h4>
                                    <hr>
                                    <div class="tab-content">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <p>
                                                    <strong>Razão social:</strong>
                                                    {{ $request->contract?->Supplier->corporate_name ?? '---' }}
                                                </p>
                                                <p>
                                                    <strong>Nome fantasia:</strong>
                                                    {{ $request->contract?->Supplier->name ?? '---' }}
                                                </p>
                                                <p>
                                                    <strong>CPF/CNPJ:</strong>
                                                    {{ $request->contract?->Supplier->cpf_cnpj ?? '---' }}
                                                </p>
                                                <p>
                                                    <strong>Indicação:</strong>
                                                    {{ $request->contract?->Supplier->supplier_indication ?? '---' }}
                                                </p>
                                                
                                            </div>
                                            <div class="col-sm-6">
                                                <p>
                                                    <strong>Qualifacação:</strong>
                                                    {{ $request->contract->Supplier->qualification->label() ?? '---' }}
                                                </p>
                                                <p>
                                                    <strong>Tipo de mercado:</strong>
                                                    {{ $request->contract?->Supplier->market_type ?? '---' }}
                                                </p>
                                                <p>
                                                    <strong>Representante:</strong>
                                                    {{ $request->contract?->Supplier->representative ?? '---' }}
                                                </p>
                                                <p>
                                                    <strong>E-mail:</strong>
                                                    {{ $request->contract?->Supplier->email ?? '---' }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr class="pagebreak"/>

                            <div class="request-details-content">
                                <div class="request-details-content-box">
                                    <h4><i class="glyphicon glyphicon-list-alt"></i> <strong>Contrato - Informações</strong></h4>
                                    <div class="tab-content padding">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <p>
                                                    <strong>Nome do contrato:</strong> {{ $request->contract->name }}
                                                </p>
                                                <p>
                                                    <strong>Status do contrato:</strong>
                                                    {{ $request->contract->is_active ? 'Ativo' : 'Inativo' }}
                                                </p>
                                                <hr>
                                                <p>
                                                    <strong>Recorrência do pagamento:</strong>
                                                    {{ $request->contract->recurrence->label() }}
                                                </p>
                                                <p>
                                                    <strong>Flexibilidade do pagamento:</strong> Pgto.
                                                    {{ $request->contract->is_fixed_payment ? 'fixo' : 'variável' }}
                                                </p>
                                                <p>
                                                    <strong>Tipo de quitação:</strong> Pgto.
                                                    {{ $request->contract->is_prepaid ? 'antecipado' : 'pós-pago' }}
                                                </p>
                                                <p>
                                                    <strong>Local do serviço:</strong>
                                                    {{ $request->contract->local_service ?? '---' }}
                                                </p>
                                                <p>
                                                    <strong>Valor total do contrato:</strong>
                                                    {{ $request->contract->total_ammount ?? '---' }}
                                                </p>
                                                <p>
                                                    <strong>Qtd. de parcelas:</strong>
                                                    {{ $request->contract->quantity_of_installments ?? '---' }}
                                                </p>
                                                <p>
                                                    <strong>Representante:</strong>
                                                    {{ $request->contract->supplier->representative ?? '---' }}
                                                </p>
                                                <p>
                                                    <strong>E-mail:</strong>
                                                    {{ $request->contract->supplier->email ?? '---' }}
                                                </p>
                                            </div>
                                            <div class="col-md-4">
                                                <p>
                                                    <strong>Razão social:</strong>
                                                    {{ $request->contract->supplier->corporate_name }}
                                                </p>
                                                <p>
                                                    <strong>Nome fantasia:</strong>
                                                    {{ $request->contract->supplier->name }}
                                                </p>
                                                <p>
                                                    <strong>CNPJ/CPF:</strong> {{ $request->contract->supplier->cpf_cnpj }}
                                                </p>
                                                <p>
                                                    <strong>Tipo de pessoa:</strong>
                                                    {{ $request->contract->supplier->entity_type }}
                                                </p>
                                                <p>
                                                    <strong>Indicação do fornecedor:</strong>
                                                    {{ $request->contract->supplier->supplier_indication }}
                                                </p>
                                                <p>
                                                    <strong>Tipo de mercado:</strong>
                                                    {{ $request->contract->supplier->market_type }}
                                                </p>
                                                <p>
                                                    <strong>Qualificação:</strong>
                                                    {{ $request->contract->supplier->qualification->label() }}
                                                </p>
                                                <p>
                                                    <strong>Registro estadual:</strong>
                                                    {{ $request->contract->supplier->state_registration ?? '---' }}
                                                </p>
                                                <p>
                                                    <strong>Descrição do fornecedor:</strong>
                                                    {{ $request->contract->supplier->description ?? '---' }}
                                                </p>
                                            </div>
                                            <div class="col-md-4">
                                                <p>
                                                    <strong>Dia de pagamento:</strong>
                                                    {{ Carbon\Carbon::parse($request->contract->payday)->format('d/m/Y') }}
                                                </p>
                                                <p>
                                                    <strong>Vigência - Dia de início:</strong>
                                                    {{ $request->contract->start_date ? Carbon\Carbon::parse($request->contract->start_date)->format('d/m/Y') : '---' }}
                                                </p>
                                                <p>
                                                    <strong>Vigência - Dia de fim:</strong>
                                                    {{ $request->contract->end_date ? Carbon\Carbon::parse($request->contract->end_date)->format('d/m/Y') : '---' }}
                                                </p>
                                                <p>
                                                    <strong>Contrato criado em:</strong>
                                                    {{ Carbon\Carbon::parse($request->contract->created_at)->format('d/m/Y') }}
                                                </p>
                                                <p>
                                                    <strong>Contrato atualizado em:</strong>
                                                    {{ Carbon\Carbon::parse($request->contract->updated_at)->format('d/m/Y') }}
                                                </p>
                                                <p>
                                                    <strong>Fornecedor criado em:</strong>
                                                    {{ $request->contract->supplier->created_at }}
                                                </p>
                                                <p>
                                                    <strong>Fornecedor atualizado em:</strong>
                                                    {{ $request->contract->supplier->updated_at }}
                                                </p>
                                                <hr>
                                                <p>
                                                    <strong>Descrição: </strong>
                                                    {{ $request->contract->descrilabeltion ?? '---' }}
                                                </p>
                                            </div>
                                        </div>

                                        <hr class="pagebreak"/>

                                        <div class="request-details-content-box-contract">
                                            <h4 style="padding: 0 15px"><i class="glyphicon glyphicon-list-alt"></i> <strong> Parcelas</strong></h4>
                                            @foreach ($request->contract->installments as $installmentIndex => $installment)
                                            <div class="request-details-content-box-contract-installment">
                                                <div class="row">
                                                    <p class="col-xs-2">
                                                        <strong>Parcela nº:</strong> {{ $installmentIndex + 1 }}
                                                    </p>
                                                    <p class="col-xs-2">
                                                        <strong>Valor:</strong> {{ $installment->value }}
                                                    </p>
                                                    <p class="col-xs-2">
                                                        <strong>Pago no dia:</strong> {{ $installment->payment_day ?? '---' }}
                                                    </p>
                                                    <p class="col-xs-6">
                                                        <strong>Descrição do pagamento:</strong> <span>{{ $installment->description ?? '---' }}</span>
                                                    </p>
                                                </div>
                                            </div>
                                            @if ($installmentIndex === 14)
                                                <hr class="pagebreak"/>
                                            @endif
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

        <hr>

        <div class="row">
            <div class="col-md-12">
                 <h4><i class="glyphicon glyphicon-file"></i> <strong>Anexos:</strong></h4>
                 @if ($request->purchaseRequestFile->count())
                    <ul>
                        @foreach ($request->purchaseRequestFile as $index => $file)
                            <li><a style="font-size: 16px" href="{{ $file->path }}" target="_blank" rel="noopener noreferrer">Link {{$index + 1}}</a></li>                        
                        @endforeach
                    </ul>
                @else
                    <p>Ainda não há registros aqui.</p>   
                 @endif
            </div>
        </div>

        <hr>

        <div class="row">
            <div class="col-md-12">
                <h4><i class="glyphicon glyphicon-link"></i> <strong>Links de apoio/sugestão:</strong></h4>
                @php
                    $supportLinks = 'Não há links para serem exibidos aqui.';
                    if( $request?->support_links) {
                        $supportLinks = str_replace(' ', '<br>', $request->support_links);
                        $supportLinks = nl2br($supportLinks);
                    }
                @endphp
                <p class="support_links" style="max-height: 300px; overflow:auto">{!! $supportLinks !!}</p>
            </div>
        </div>
    </div>
</x-app>
