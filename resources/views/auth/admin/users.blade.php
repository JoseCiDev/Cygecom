@extends('layouts.app')

@section('content')

<div>
    <div class="container">
        <h1>Gerenciamento de usuários</h1>
        <div class="box box-color box-bordered colored">
            <div class="box-title">
                <h3>
                    <i class="fa fa-th"></i>Lista de usuários
                </h3>
            </div>
            <div class="box-content">
                @foreach ($users as $user)
                   <div class="row bg-info user-item-list">
                        <div class="col-md-3">
                            <p>ID: {{$user['id']}} | <i class="fa fa-envelope"></i> - {{$user['email']}}</p>
                            <p>Pessoa: {{$user['person']['name']}}</p>
                        </div>
                        <div class="col-md-1">
                            <p>Perfil: {{$user['profile']['profile_name']}}</p>
                        </div>
                        <div class="col-md-2">
                            <p>Aprovador: {{$user['approver_user_id']}}</p>
                            <p>Limite de aprovação: {{$user['approve_limit']}}</p>
                        </div>
                        <div class="col-md-4">
                            <p>Criado em: {{ \Carbon\Carbon::parse($user['created_at'])->format('d/m/Y H:i:s') }}</p>
                        </p>
                            <p>Atualizado em: {{ \Carbon\Carbon::parse($user['created_at'])->format('d/m/Y H:i:s') }}</p>
                        </div>
                        <div  class="col-md-1">
                            <a href="{{ url('users/' . $user['id']) }}" class="btn btn-inverse btn--icon">
                                <i class="fa fa-cog"></i>Configurar usuário
                            </a>
                        </div>
                   </div>
                @endforeach
            </div>
        </div>
    </div>  
</div>
@endsection
