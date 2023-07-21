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
@endphp

<x-app>
    <x-slot name="title">
        <h1>Página de suprimentos</h1>
    </x-slot>

    <div class="request-details">
        <header class="request-details-header">
            <img class="request-details-header-logo"
                src="https://s3.amazonaws.com/gupy5/production/companies/32213/career/73435/images/2022-06-29_14-57_logo.jpg"
                alt="Logo Essentia Group">
            <h1>Solicitação de serviço nº {{ $request->id }}</h1>
            <div>
                <span>Criado em: {{ \Carbon\Carbon::parse($request->created_at)->format('d/m/Y h:m:s') }}</span> |
                <span>Atualizado: {{ \Carbon\Carbon::parse($request->updated_at)->format('d/m/Y h:m:s') }}</span>
            </div>
            <p>Serviço desejado para:
                {{ $request->desired_date ? \Carbon\Carbon::parse($request->desired_date)->format('d/m/Y') : '---' }}
            </p>
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
                                    <p>
                                        <strong>Status de aprovação:</strong> {{ $request->status->label() }}
                                    </p>
                                    <p>
                                        <strong>Tipo de solicitação:</strong> {{ $request->type->label() }}
                                    </p>
                                    <p>
                                        <strong>Contratação deve ser por:</strong>
                                        {{ $request->is_supplies_contract ? 'Suprimentos' : 'Centro de custo solicitante' }}
                                    </p>
                                    <p>
                                        <strong>COMEX:</strong> {{ $request->is_comex ? 'Sim' : 'Não' }}
                                    </p>
                                    <p>
                                        <strong>Link de sugestão:</strong>
                                        @if ($request->PurchaseRequestFile->first()?->path)
                                            <a href="{{ $request->PurchaseRequestFile->first()->path }}" target="_blank"
                                                rel="noopener noreferrer">link</a>
                                        @else
                                            ---
                                        @endif
                                    </p>
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
                                <h4><i class="fa fa-user"></i><strong> Informações do solicitante</strong></h4>
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
                                        <strong>Usuário aprovador:</strong>
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
                        <div class="request-details-content">
                            <div class="request-details-content-box">
                                <h4><i class="fa fa-money"></i> <strong>Centro de custo e rateio</strong></h4>
                                <hr>
                                <p>
                                    <strong>Qtd. de centro de custos:</strong>
                                    {{ $request->costCenterApportionment->count() }}
                                </p>
                                <div class="tab-content request-details-content-box-apportionment">
                                    @foreach ($request->costCenterApportionment as $index => $apportionment)
                                        <div class="row">
                                            <div class="col-sm-2">
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
                                            <div class="col-sm-5">
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
                        <div class="request-details-content">
                            <div class="request-details-content-box">
                                <h4><i class="fa fa-truck"></i> <strong>Fornecedor</strong></h4>
                                <hr>
                                <div class="tab-content">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <p>
                                                <strong>Razão social:</strong>
                                                {{ $request->service?->Supplier->corporate_name ?? '---' }}
                                            </p>
                                            <p>
                                                <strong>Nome fantasia:</strong>
                                                {{ $request->service?->Supplier->name ?? '---' }}
                                            </p>
                                            <p>
                                                <strong>CPF/CNPJ:</strong>
                                                {{ $request->service?->Supplier->cpf_cnpj ?? '---' }}
                                            </p>
                                            <p>
                                                <strong>Indicação:</strong>
                                                {{ $request->service?->Supplier->supplier_indication ?? '---' }}
                                            </p>
                                            
                                        </div>
                                        <div class="col-sm-6">
                                            <p>
                                                <strong>Qualifacação:</strong>
                                                {{ $request->service->Supplier->qualification->label() ?? '---' }}
                                            </p>
                                            <p>
                                                <strong>Tipo de mercado:</strong>
                                                {{ $request->service?->Supplier->market_type ?? '---' }}
                                            </p>
                                            <p>
                                                <strong>Representante:</strong>
                                                {{ $request->service?->Supplier->representative ?? '---' }}
                                            </p>
                                            <p>
                                                <strong>E-mail:</strong>
                                                {{ $request->service?->Supplier->email ?? '---' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="request-details-content">
                            <div class="request-details-content-box">
                                <h4><i class="fa fa-briefcase"></i> <strong>Serviço - Informações</strong></h4>
                                <div class="tab-content padding">
                                    <p>
                                        <strong>Status geral:</strong> Processo
                                        {{ $request->service->is_fineshed ? 'finalizado' : 'em andamento' }}
                                    </p>
                                    <p>
                                        <strong>Tipo de quitação:</strong> Pgto.
                                        {{ $request->service->is_prepaid ? 'antecipado' : 'pós-pago' }}
                                    </p>
                                    <p>
                                        <strong>Dia do pagamento:</strong>
                                        {{ $request->service->payday ? \Carbon\Carbon::parse($request->service->payday)->format('d/m/Y') : 'Não informado' }}
                                    </p>
                                    <p>
                                        <strong>Preço total:</strong> R$ {{ $request->service->price ?? '---' }}
                                    </p>
                                    <p>
                                        <strong>Status da execução:</strong> Serviço
                                        {{ $request->service->already_provided ? 'já executado' : 'não executado' }}
                                    </p>
                                    <p>
                                        <strong>Horas trabalhadas:</strong>
                                        {{ $request->service->hours_performed ?? '---' }}
                                    </p>
                                    <p>
                                        <strong>Local do serviço:</strong>
                                        {{ $request->service->local_service ?? '---' }}
                                    </p>
                                    <hr>
                                    <p>
                                        <strong>Vendedor/Atendente responsável:</strong>
                                        {{ $request->service->seller ?? '---' }}
                                    </p>
                                    <p>
                                        <strong>Celular/Telefone do responsável:</strong>
                                        {{ $request->service->phone ?? '---' }}
                                    </p>
                                    <p>
                                        <strong>E-mail do responsável:</strong> {{ $request->service->email ?? '---' }}
                                    </p>
                                </div>
                            </div>
                            <div class="request-details-content-box">
                                <h4><i class="fa fa-briefcase"></i> <strong>Serviço - Informações de pagamento</strong>
                                </h4>
                                <div class="tab-content padding">
                                    <p>
                                        <strong>Tipo do pagamento:</strong>
                                        {{ $request->service->paymentInfo->payment_type ?? '---' }}
                                    </p>
                                    <p>
                                        <strong>Detalhes:</strong>
                                        {{ $request->service->paymentInfo->description ?? '---' }}
                                    </p>
                                    <hr>
                                    <p>
                                        <strong>Informações criadas em:</strong>
                                        {{ \Carbon\Carbon::parse($request->service->paymentInfo->created_at)->format('d/m/Y h:m:s') }}
                                    </p>
                                    <p>
                                        <strong>Informações atualizado em:</strong>
                                        {{ \Carbon\Carbon::parse($request->service->paymentInfo->updated_at)->format('d/m/Y h:m:s') }}
                                    </p>
                                </div>
                                <hr>
                                <h4><i class="fa fa-briefcase"></i> <strong>Serviço - Descrição</strong></h4>
                                <p>
                                    <strong>Descrição do serviço:</strong>{{ $request->service->description }}
                                </p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </main>
    </div>
</x-app>
