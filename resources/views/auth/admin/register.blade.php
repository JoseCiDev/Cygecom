<x-app>

    <x-slot name="title">
        <h1>Cadastro</h1>
    </x-slot>

    <x-user.create-update action="register" :approvers="$approvers" :costCenters="$costCenters" />
</x-app>
