<x-app>
    <x-slot name="title">
        <h1>Produtos</h1>
    </x-slot>

    <x-modalDelete/>

        <div class="row">
            <div class="col-sm-12">
                <div class="box box-color box-bordered">

                    <div class="box-title">
                        <div class="row">
                            <div class="col-md-6">
                                <h3 class="pull-left">Todos os produtos</h3>
                            </div>
                            <div class="col-md-6">
                                <a href="{{route('productRegister')}}" class="btn pull-right" style="margin-right: 15px">Registrar novo produto</a>
                            </div>
                        </div>
                    </div>

                    <div class="box-content nopadding">

                        <table
                            class="table table-hover table-nomargin table-bordered dataTable"
                            data-column_filter_dateformat="dd-mm-yy" data-nosort="0" data-checkall="all">
                            <thead>
                                <tr>
                                    <th class="col-md-4">Descrição</th>
                                    <th class="col-md-3">Categoria</th>
                                    <th class='hidden-350 col-md-2'>Valor unitário (R$)</th>
                                    <th class='hidden-1024 col-md-2'>Atualizado em</th>
                                    <th class='hidden-480 col-md-1' >Opções</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($products as $product)
                                <tr>
                                    <td>{{$product->name}}</td>
                                    <td >{{$product->categorie->name ?? "Não definida"}}</td>
                                    <td class='hidden-1024'><strong>{{$product->unit_price}}</strong></td>
                                    <td class='hidden-350'>{{\Carbon\Carbon::parse($product->updated_at)->format('d/m/Y - H:m:s')}}</td>
                                    <td class='hidden-480'>
                                        <a href="{{route('product', ['id' => $product->id])}}" class="btn" rel="tooltip" title="Edit"><i class="fa fa-edit"></i></a>
                                        <button data-route="products" data-name="{{$product->name}}" data-id="{{$product->id}}" rel="tooltip" title="Excluir"
                                                class="btn" data-toggle="modal" data-target="#modal"  ><i class="fa fa-times"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach

                        </table>
                    </div>
                </div>
            </div>
        </div>

</x-app>
