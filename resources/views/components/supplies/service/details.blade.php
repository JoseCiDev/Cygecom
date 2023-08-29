@php
    use App\Enums\{PurchaseRequestStatus, PurchaseRequestType};

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
            <form class="form-validate" data-cy="form-request-status" method="POST" action="{{ route('supplies.request.status.update', ['id' => $request->id]) }}">
            @csrf
                <div class="row">
                   <div class="col-md-12">
                        <label for="status">Status da solicitação</label>
                   </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <select name="status" data-cy="status" @disabled($requestIsFromLogged)>
                            @foreach ($allRequestStatus as $status)
                                @if ($status->value !== PurchaseRequestStatus::RASCUNHO->value);
                                    <option @selected($request->status === $status) value="{{$status}}">{{$status->label()}}</option>
                                @endif
                            @endforeach
                        </select>
                        <button ata-cy="btn-apply-status" type="submit" class="btn btn-icon btn-small btn-primary" @disabled($requestIsFromLogged)> Aplicar status </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="pull-right">
                <x-PdfGeneratorButton print-by-selector=".details-content" :file-name="'solicitacao_servico_'.$request->id . now()->format('dmY_His_u')"/>
            </div>
        </div>
    </div>

    <div class="request-details">
        <div class="details-content">
            <header class="request-details-header">
                <h1 class="text-highlight"><strong>Solicitação de serviço nº {{ $request->id }}</strong></h1>
                <div>
                    <span>Criado em: {{ \Carbon\Carbon::parse($request->created_at)->format('d/m/Y h:m:s') }}</span> |
                    <span>Atualizado: {{ \Carbon\Carbon::parse($request->updated_at)->format('d/m/Y h:m:s') }}</span>
                </div>
                <h4 class="text-highlight">
                    <strong>
                        Data da prestação do serviço:
                    </strong>
                    {{ $request->desired_date ? \Carbon\Carbon::parse($request->desired_date)->format('d/m/Y') : '---' }}
                </h4>
                <div class="row">
                    <div class="col-md-12">
                        <br>
                        <h4 class="text-highlight"><strong>Responsável pela solicitação (suprimentos):</strong> {{$request->suppliesUser?->person->name ?? '---'}} / {{$request->suppliesUser?->email ?? "---"}}</h4>
                        <br>
                        <h4 class="text-highlight"><strong>Responsável pela contratação:</strong> {{ $request->is_supplies_contract ? 'Suprimentos' : 'Área solicitante' }} </h4>
                        <br>
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
                                        <p>
                                            <strong>Status de aprovação:</strong> {{ $request->status->label() }}
                                        </p>
                                        <p>
                                            <strong>Tipo de solicitação:</strong> {{ $request->type->label() }}
                                        </p>
                                        <p>
                                            <strong>COMEX:</strong> {{ $request->is_comex ? 'Sim' : 'Não' }}
                                        </p>
                                        <p>
                                            <strong>Motivo da solicitação:</strong> {{ $request->reason }}
                                        </p>
                                        <p>
                                            <strong>Observação:</strong> {{ $request->observation ?? '---' }}
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
                                            <strong>Autorização para solicitar:</strong>
                                            {{ $request->user->is_buyer ? 'Autorizado' : 'Sem autorização' }}
                                        </p>
                                        <p>
                                            <strong>Aprovação limite:</strong>
                                            {{ $request->user->approver_limit ?? 'Sem limite' }}
                                        </p>
                                        <p>
                                            <strong>Usuário aprovador:</strong>
                                            {{ $request->user->approver->person->name ?? 'Sem aprovador' }}
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

                            <br>

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

                            <br>

                            <div class="request-details-content">
                                <div class="request-details-content-box">
                                    <h4><i class="fa fa-truck"></i> <strong>Fornecedor</strong></h4>
                                    <hr>
                                    <div class="tab-content">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <p>
                                                    <strong>Razão social:</strong>
                                                    {{ $request->service->supplier?->corporate_name ?? '---' }}
                                                </p>
                                                <p>
                                                    <strong>Nome fantasia:</strong>
                                                    {{ $request->service->supplier?->name ?? '---' }}
                                                </p>
                                                <p>
                                                    <strong>CPF/CNPJ:</strong>
                                                    {{ $request->service->supplier?->cpf_cnpj ?? '---' }}
                                                </p>
                                                <p>
                                                    <strong>Indicação:</strong>
                                                    {{ $request->service->supplier?->supplier_indication ?? '---' }}
                                                </p>

                                            </div>
                                            <div class="col-sm-4">
                                                <p>
                                                    <strong>Qualifacação:</strong>
                                                    {{ $request->service->supplier?->qualification->label() ?? '---' }}
                                                </p>
                                                <p>
                                                    <strong>Tipo de mercado:</strong>
                                                    {{ $request->service->supplier?->market_type ?? '---' }}
                                                </p>
                                                <p>
                                                    <strong>Representante:</strong>
                                                    {{ $request->service->supplier?->representative ?? '---' }}
                                                </p>
                                                <p>
                                                    <strong>E-mail:</strong>
                                                    {{ $request->service->supplier?->email ?? '---' }}
                                                </p>
                                            </div>
                                            <div class="col-sm-4">
                                                <p>
                                                    <strong>Descrição:</strong>
                                                    {{ $request->service->supplier->description ?? '---' }}
                                                </p>
                                                <p>
                                                    <strong>Observações tributárias:</strong>
                                                    {{ $request->service->supplier->tributary_observation ?? '---' }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <br>

                            <div class="request-details-content">
                                <div class="request-details-content-box">
                                    <div class="tab-content padding">
                                        <h4><i class="fa fa-briefcase"></i> <strong>Serviço - Informações</strong></h4>
                                        <p>
                                            <strong>Condição de pagamento: </strong>
                                            {{ $request->service->paymentInfo?->payment_terms?->label() ?? '---' }}
                                        </p>
                                        <p>
                                            <strong>Dia do pagamento:</strong>
                                            {{ $request->service->payday ? \Carbon\Carbon::parse($request->service->payday)->format('d/m/Y') : 'Não informado' }}
                                        </p>
                                        <p>
                                            <strong>Preço total:</strong> R$ {{ $request->service->price ?? '---' }}
                                        </p>
                                        <p>
                                            <strong>Este serviço já foi prestado:</strong>  {{ $request->service->already_provided ? 'Sim' : 'Não' }}
                                        </p>
                                        <p>
                                            <strong>Local de prestação do serviço:</strong>
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
                                    <div class="tab-content padding">
                                        <h4><i class="fa fa-briefcase"></i> <strong>Serviço - Informações de pagamento</strong></h4>
                                        <p>
                                            <strong>Forma de pagamento:</strong>
                                            {{ $request->service->paymentInfo->payment_method?->label() ?? '---' }}
                                        </p>
                                        <p>
                                            <strong>Detalhes:</strong>
                                            {{ $request->service->paymentInfo->description ?? '---' }}
                                        </p>
                                    </div>
                                    <hr>
                                    <h4><i class="fa fa-briefcase"></i> <strong>Serviço - Descrição</strong></h4>
                                    <p>
                                        <strong>Descrição do serviço:</strong> {{ $request->description ?? '---' }}
                                    </p>
                                </div>
                            </div>

                            <br>

                            <div class="request-details-content-box">
                                <div class="request-details-content-box-service">
                                    <h4 style="padding: 0 15px"><i class="glyphicon glyphicon-list-alt"></i> <strong> Parcelas</strong></h4>
                                    @foreach ($request->service->installments as $installmentIndex => $installment)
                                    <div class="request-details-content-box-service-installment">
                                        <div class="row">
                                            <p class="col-xs-3">
                                                <strong>Parcela nº:</strong> {{ $installmentIndex + 1 }}
                                            </p>
                                            <p class="col-xs-3">
                                                <strong>Quitação:</strong> {{ $installment->status ?? '---' }}
                                            </p>
                                            <p class="col-xs-6">
                                                <strong>Observação do pagamento:</strong> <span>{{ $installment->observation ?? '---' }}</span>
                                            </p>
                                        </div>
                                        <div class="row">
                                            <p class="col-xs-3">
                                                <strong>Valor (R$):</strong> {{ $installment->value }}
                                            </p>
                                            <p class="col-xs-3">
                                                <strong>Vencimento:</strong> {{$installment->expire_date ? \Carbon\Carbon::parse($installment->expire_date)->format('d/m/Y') : '---'}}
                                            </p>
                                        </div>
                                    </div>
                                    @endforeach
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
                 @if ($files->count())
                    <ul>
                        @foreach ($files as $index => $file)
                            <li><a style="font-size: 16px" data-cy="link-{{ $index }}" href="{{ env('AWS_S3_BASE_URL') . $file->path }}" target="_blank" rel="noopener noreferrer">{{ $file->original_name }}</a></li>
                        @endforeach
                    </ul>
                 @else
                    <p>Nenhum registro encontrado.</p>
                 @endif
            </div>
        </div>

        <hr>

        <div class="row justify-content-center">
            <div class="col-sm-12">
                <x-RequestFiles :purchaseRequestId="$request?->id" isSupplies :purchaseRequestType="PurchaseRequestType::SERVICE" />
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

        <hr>

        <div class="row">
            <div class="col-md-12">
                <x-SuppliesLogList :purchaseRequestId="$request->id" />
            </div>
        </div>

    </div>
</x-app>
