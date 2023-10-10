<x-app>

    <div class="row">
        <div class="col-sm-12">
            <div class="box box-color box-bordered colored">
                <x-user.create-update action="user.update"  :user="$user" :approvers="$approvers" :costCenters="$costCenters" />
            </div>
        </div>
    </div>

</x-app>
