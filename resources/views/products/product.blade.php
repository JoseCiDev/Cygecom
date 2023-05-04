<x-app>
    <x-slot name="title">
        <h1>Atualizar produto</h1>
    </x-slot>

    <x-modalDelete/>

    <div class="row">
        <div class="col-sm-12">
            <div class="box box-color box-bordered colored">
                <div class="box-title">
                    <div class="row">
                        <div class="col-md-6">
                            <h3 style="color: white; margin-top: 5px" class="pull-left">Atualizar produto</h3>
                        </div>
                        <div class="col-md-6 pull-right">
                            <button data-route="products" data-name="{{$product->description}}" data-id="{{$product->id}}" data-toggle="modal" data-target="#modal"
                                rel="tooltip" title="Excluir" class="btn btn-danger pull-right" style="margin-right: 15px">
                                Excluir produto
                            </button>
                        </div>
                    </div>
                </div>
                <div class="box-content">
                    <form method="POST" action="{{route('updateProduct' , ['id' => $product->id])}}">
                        @csrf

                        <div class="row">
                            <div class="col-md-7">
                                <div class="form-group">
                                    <label for="description" class="control-label"><sup style="color:red">*</sup>Nome/Descrição</label>
                                    <input type="text" name="description" id="description" placeholder="Exemplo: Becker de Vidro 250ml" class="form-control" value="{{$product->description}}"> 
                                    @error('description')<strong>{{ $message }}</strong>@enderror
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="unit_price" class="control-label"><sup style="color:red">*</sup>Valor unitário</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">R$</span>
                                        <input type="number" name="unit_price" id="unit_price" placeholder="0.00" class="form-control" min="0" step="0.01" value="{{number_format($product->unit_price, 2, '.', '')}}">
                                        @error('unit_price') <p><strong>{{ $message }}</strong></p> @enderror
                                    </div>
                                </div>
                            </div>
                           <div class="col-md-3">
                                <div class="form-group">
                                    <label for="textfield" class="control-label col-md-12">Selecione uma categoria</label>
                                    <div class="col-md-12">
                                        <select name="product_categorie_id" id="product_categorie_id" class='chosen-select form-control'>
                                            <option value="">Categoria</option>
                                            @foreach ($categories as $categorie)
                                                <option value="{{$categorie->id}}" @if ($product->categorie->id === $categorie->id) selected @endif >
                                                    {{$categorie->name}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                           </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <span>Criado em:</span>
                                <p class="form-control">{{$product->created_at}}</p>
                           </div>
                           <div class="col-md-3">
                                <span>Atualizado em:</span>
                                <p class="form-control">{{$product->updated_at}}</p>
                           </div>
                           <div class="col-md-3">
                                <span>Atualizado por:</span>
                                <p class="form-control">{{$product->updaterUser->person->name ?? ''}}</p>
                           </div>
                        </div>

                        <div class="form-actions pull-right">
                            <button type="submit" class="btn btn-primary">Atualizar</button>
                            <a href="{{ url()->previous() }}" class="btn">Cancelar</a>
                        </div> 
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-app>