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
                        <p>Este é o portal de gerenciamento de compras dao grupo Essentia!</p>
                        {{-- Para acesso rápido --}}
                        @if (auth()->user()->profile->name === 'admin')
                            <p>TESTE E-MAIL</p>
                            <a class="btn btn-primary" href="{{ route('email') }}">E-mail</a>
                        @endif

                    </div>
                </div>
            </div>
        </div>

        <!-- exemplo de uso de envio de arquivo -->
        <!-- Multiple -->
        <div class="row justify-content-center">
            <div class="col-12">
                <fieldset>
                    <legend>Upload file - Multiple</legend>
                    <form method="POST" action="/" enctype="multipart/form-data">
                        @csrf
                        <input type="file" class="form-control" name="arquivo_teste[]" multiple>
                        <input class="btn btn-primary" type="submit">
                    </form>
                </fieldset>
            </div>
        </div>
        <!-- Single -->
        <div class="row justify-content-center">
            <div class="col-12">
                <fieldset>
                    <legend>Upload file - Single</legend>
                    <form method="POST" action="/" enctype="multipart/form-data">
                        @csrf
                        <input type="file" class="form-control" name="arquivo_teste">
                        <input class="btn btn-primary" type="submit">
                    </form>
                </fieldset>
            </div>
        </div>
        <!-- fim do exemplo -->

    </div>

</x-app>
