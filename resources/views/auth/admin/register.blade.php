<x-app>

    <x-slot name="title">
        <h1>Cadastro</h1>
    </x-slot>

    <div class="row">
        <div class="col-sm-12">
            <div class="box box-color box-bordered colored">
                <x-form.user.create-update action="register" :approvers="$approvers" :costCenters="$costCenters" />
            </div>
        </div>
    </div>

</x-app>
