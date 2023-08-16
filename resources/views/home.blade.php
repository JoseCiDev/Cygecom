<x-app>
    <x-slot name="title">
        <h1>Página Principal</h1>
    </x-slot>
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
                        <p>
                            Este portal tem como objetivo fazer com que suprimentos efetue e finalize todas as
                            solicitações de compras e contratações de serviços do Grupo Essentia.
                        </p>

                        @if (config('app.env') === 'local' && auth()->user()->profile->name === 'admin')
                            <p>TESTE E-MAIL</p>
                            <a class="btn btn-primary" href="{{ route('email') }}">E-mail</a>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app>
