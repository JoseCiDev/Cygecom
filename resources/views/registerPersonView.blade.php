@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Registar pessoa') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('registerPerson') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Nome') }}</label>
                            <div class="col-md-6"><input id="name" type="text" class="form-control" name="name" required></div>
                        </div>
                        <div class="row mb-3">
                            <label for="birthdate" class="col-md-4 col-form-label text-md-end">{{ __('Nascimento') }}</label>
                            <div class="col-md-6"><input id="birthdate" type="date" class="form-control" name="birthdate" required></div>
                        </div>
                        <div class="row mb-3">
                            <label for="document_number" class="col-md-4 col-form-label text-md-end">{{ __('CPF/CNPJ') }}</label>
                            <div class="col-md-6"><input id="document_number" type="text" class="form-control" name="document_number" required></div>
                        </div>
                        <div class="row mb-3">
                            <label for="phone" class="col-md-4 col-form-label text-md-end">{{ __('Telefone/Celular') }}</label>
                            <div class="col-md-6">
                                <input id="phone" type="text" class="form-control mb-3" name="phone" required>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="phone_type" id="personal" value="personal" checked>
                                    <label class="form-check-label" for="personal">
                                        Pessoal
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="phone_type" id="commercial" value="commercial">
                                    <label class="form-check-label" for="commercial">
                                        Comercial
                                    </label>
                                </div>
                            </div>
                        </div>
                        <hr>

                        <div class="row mb-3">
                            <label for="country" class="col-md-4 col-form-label text-md-end">{{ __('País') }}</label>
                            <div class="col-md-6"><input id="country" type="text" class="form-control" name="country" required></div>
                        </div>
                        <div class="row mb-3">
                            <label for="postal_code" class="col-md-4 col-form-label text-md-end">{{ __('CEP') }}</label>
                            <div class="col-md-6"><input id="postal_code" type="text" class="form-control" name="postal_code" required></div>
                        </div>
                        <div class="row mb-3">
                            <label for="state" class="col-md-4 col-form-label text-md-end">{{ __('Estado/UF') }}</label>
                            <div class="col-md-6"><input id="state" type="text" class="form-control" name="state" required></div>
                        </div>
                        <div class="row mb-3">
                            <label for="city" class="col-md-4 col-form-label text-md-end">{{ __('Cidade') }}</label>
                            <div class="col-md-6"><input id="city" type="text" class="form-control" name="city" required></div>
                        </div>
                        <div class="row mb-3">
                            <label for="neighborhood" class="col-md-4 col-form-label text-md-end">{{ __('Bairro') }}</label>
                            <div class="col-md-6"><input id="neighborhood" type="text" class="form-control" name="neighborhood" required></div>
                        </div>
                        <div class="row mb-3">
                            <label for="street" class="col-md-4 col-form-label text-md-end">{{ __('Rua') }}</label>
                            <div class="col-md-6"><input id="street" type="text" class="form-control" name="street" required></div>
                        </div>
                        <div class="row mb-3">
                            <label for="street_number" class="col-md-4 col-form-label text-md-end">{{ __('Número') }}</label>
                            <div class="col-md-6"><input id="street_number" type="number" class="form-control" name="street_number" required></div>
                        </div>
                        <div class="row mb-3">
                            <label for="complement" class="col-md-4 col-form-label text-md-end">{{ __('Complemento') }}</label>
                            <div class="col-md-6"><input id="complement" type="text" class="form-control" name="complement"></div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Próximo') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
