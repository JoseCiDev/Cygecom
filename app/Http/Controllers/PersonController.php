<?php

namespace App\Http\Controllers;

use App\Providers\PersonService;
use Illuminate\Http\Request;

class PersonController extends Controller
{
    private $personService;

    public function __construct(PersonService $personService)
    {
        $this->personService = $personService;
    }

    public function registerPersonView()
    {
        return view("registerPersonView");
    }
    public function registerPerson(Request $request)
    {
        $personId = $this->personService->registerPerson($request);
        $request->session()->put('person_id', $personId);
        return redirect('register');
    }
}
