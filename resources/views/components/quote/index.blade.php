<x-app>
    <x-slot name="title">
        <h1>Cotações</h1>
    </x-slot>

    <x-modalDelete/>

        <div class="row">
            <div class="col-sm-12">
                <div class="box box-color box-bordered">

                    <div class="box-title">
                        <div class="row">
                            <div class="col-md-6">
                                <h3 class="pull-left">Todas as cotações</h3>
                            </div>
                            <div class="col-md-6">
                                <a
                                    href="{{ route('quotationRegister') }}"
                                    class="btn pull-right btn-large"
                                    style="margin-right: 15px"
                                >
                                    Nova Cotação
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="box-content nopadding">

                        <table
                            class="table table-hover table-nomargin table-bordered dataTable"
                            data-column_filter_dateformat="dd-mm-yy"
                            data-nosort="0"
                            data-checkall="all"
                        >
                            <thead>
                                <tr>
                                    <th class="col-md-1">Nº Solicitação</th>
                                    <th class="col-md-1">Cotado por</th>
                                    <th class="col-md-2">Tipo</th>
                                    <th class="col-md-4">Centro de custo</th>
                                    <th class='hidden-350 col-md-2'>Status</th>
                                    <th class='hidden-1024col-md-2'>Atualizado em</th>
                                    <th class='hidden-480 col-md-1' >Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>102</td>
                                    <td>Suprimentos</td>
                                    <td>Serviços</td>
                                    <td>INP Filial - FINANCEIRO - 4.4</td>
                                    <td class='hidden-350 col-md-2'>Finalizada</td>
                                    <td class='hidden-1024 col-md-2'>10/05/2023</td>
                                    <td class='hidden-480'>
                                        <a href="" class="btn" rel="tooltip" title="Edit">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <button class="btn">
                                                <i class="fa fa-times"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>145</td>
                                    <td>Cesar Luiz de Sousa Júnior</td>
                                    <td>Serviços</td>
                                    <td>INP Filial - P&D - 3.4</td>
                                    <td class='hidden-350 col-md-2'>Em andamento</td>
                                    <td class='hidden-1024 col-md-2'>10/04/2023</td>
                                    <td class='hidden-480'>
                                        <a href="" class="btn" rel="tooltip" title="Edit">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <button class="btn">
                                                <i class="fa fa-times"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>---</td>
                                    <td>Suprimentos</td>
                                    <td>Produtos</td>
                                    <td>INP Filial - CONGRESSO E EVENTOS - 3.3</td>
                                    <td class='hidden-350 col-md-2'>Cancelada</td>
                                    <td class='hidden-1024 col-md-2'>10/03/2023</td>
                                    <td class='hidden-480'>
                                        <a href="" class="btn" rel="tooltip" title="Edit">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <button class="btn">
                                                <i class="fa fa-times"></i>
                                        </button>
                                    </td>
                                </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

</x-app>
