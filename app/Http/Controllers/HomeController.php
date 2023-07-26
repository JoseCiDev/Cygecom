<?php

namespace App\Http\Controllers;

use App\Services\S3;
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

            if ($file instanceof \Illuminate\Http\UploadedFile || is_array($file)) {
                $uniq = uniqid(); //não precisa disso, só pra teste
                $result = S3::sendFiles($file, 'solicitacao', "id_solicitacao_aqui$uniq");
                dump($result);

                // $exemploComProvider = app('S3');
                // $result = $exemploComProvider::sendFiles($file, 'solicitacao', "id_solicitacao_aqui$uniq");
            }
            return view('home');
        }
    }
}
