<x-app>

    <x-slot name="title">
        <h1>Cadastro</h1>
    </x-slot>

    <div class="row">
        <div class="col-sm-12">
            <div class="box box-color box-bordered colored">
                <div class="box-title">
                    <h3 style="color: white; margin-top: 5px">Editar usuário</h3>
                </div>
                <div class="box-content">
                    <x-form.user.create-update action="register"/>
                </div>
            </div>
        </div>
    </div>

</x-app>
