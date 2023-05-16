<x-app>

    <x-slot name="title">
        <h1>Usuário {{$user['id']}} - {{$user['person']['name']}}</h1>
    </x-slot>

    <div class="row">
        <div class="col-sm-12">
            <div class="box box-color box-bordered colored">
                <x-form.user.create-update action="userUpdate" :user="$user"  :approvers="$approvers"  :costCenters="$costCenters"  />
            </div>
        </div>
    </div>

</x-app>
