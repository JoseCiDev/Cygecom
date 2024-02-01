<x-app>

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
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app>
