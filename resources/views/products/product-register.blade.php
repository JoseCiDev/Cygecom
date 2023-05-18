<x-app>
    <x-slot name="title">
        <h1>Registar novo produto</h1>
    </x-slot>

    <div class="row">
        <div class="col-sm-12">
            <div class="box box-color box-bordered colored">
                <div class="box-title">
                    <h3 style="color: white; margin-top: 5px">Cadastrar novo produto</h3>
                </div>
                <div class="box-content">
                    <form method="POST" action="{{route('productRegister')}}">
                        @csrf

                        <div class="personal-information">
                            <div class="row">
                                <div class="col-md-7">
                                    <div class="form-group">
                                        <label for="name" class="control-label"><sup style="color:red">*</sup>Nome/Descrição</label>
                                        <input type="text" name="name" id="name" placeholder="Exemplo: Becker de Vidro 250ml" class="form-control" required>
                                        @error('name')<strong>{{ $message }}</strong>@enderror
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="unit_price" class="control-label"><sup style="color:red">*</sup>Valor unitário</label>
                                        <div class="input-group">
                                            <span class="input-group-addon">R$</span>
                                            <input type="number" name="unit_price" id="unit_price" placeholder="0.00" class="form-control" min="0">
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
                                                    <option value="{{$categorie->id}}">{{$categorie->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                               </div>
                            </div>
                            <div class="row">
                                <div class="col-md-7">
                                    <div class="form-group">
                                        <label for="description" class="control-label">Descrição</label>
                                        <textarea name="description" id="description" placeholder="Descrição do produto..." class="form-control"></textarea>
                                        @error('description')<strong>{{ $message }}</strong>@enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-actions pull-right">
                            <button type="submit" class="btn btn-primary">Cadastrar</button>
                            <a href="{{ url()->previous() }}" class="btn">Cancelar</a>
                        </div> 
                    </form>
                </div>
            </div>
        </div>
    </div>
   

</x-app>