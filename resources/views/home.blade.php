@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <h1>Bem-vindo!</h1>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Veniam quos id modi soluta repellat, quo porro nobis aut alias dignissimos, asperiores deleniti sunt provident veritatis unde. Rerum impedit doloremque vero!</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
