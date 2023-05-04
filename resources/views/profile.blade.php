<x-app>
    <x-slot name="title">
        <h1>Perfil</h1>
    </x-slot>

    <div class="row">
        <div class="col-sm-12">
            <div class="box box-color box-bordered colored">
                <div class="box-title">
                    <h3 style="color: white; margin-top: 5px">Atualizar seu perfil</h3>
                </div>
                <div class="box-content">
                    <x-form-user-update action="userUpdate" :user="$user"/>
                </div>
            </div>
        </div>
    </div>

</x-app>
