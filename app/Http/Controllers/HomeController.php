<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        return view('home');
    }

    public function uploadFileExample(Request $request)
    {
        //Exemplo de upload de arquivo
        if ($request->isMethod('post')) {
            $file = $request->file('arquivo_teste');

            $uniq = uniqid(); //não precisa disso, só pra teste
            $result = self::sendFilesToS3($file, 'solicitacao', "id_solicitacao_aqui$uniq");
            dump($result);
            return view('home');
        }
    }
}
