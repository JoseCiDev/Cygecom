<?php

namespace App\Http\Controllers;

/**
 * @abstract rotas TESTE
 */
class OrderRequestController extends Controller
{
    public function index()
    {
        return view('components.order-request.index');
    }

    public function showRegistrationForm()
    {
        return view('components.order-request.register');
    }
}
