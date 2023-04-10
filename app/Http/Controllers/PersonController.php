<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PersonController extends Controller
{
    public function registerPersonView()
    {
        return view("registerPersonView");
    }

    public function registerPerson(Request $request)
    {
        $person = $request;
        echo "<pre>";
        var_dump($person);


        return redirect('register');
    }
}
