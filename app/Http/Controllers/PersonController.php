<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PersonController extends Controller
{
    public function registerPersonView()
    {
        return view("registerPersonView");
    }

    public function registerPerson(Request $request)
    {
        $person = [
            'name' => $request->input('name'),
            'birthdate' => $request->input('birthdate'),
        ];
        $personId = DB::table('people')->insertGetId($person);

        $complement = $request->input('complement');
        $addresses = [
            'street' => $request->input('street'),
            'street_number' => $request->input('street_number'),
            'neighborhood' => $request->input('neighborhood'),
            'postal_code' => $request->input('postal_code'),
            'city' => $request->input('city'),
            'state' => $request->input('state'),
            'country' => $request->input('country'),
            'person_id' => $personId,
            'complement' => $complement
        ];
        DB::table('addresses')->insert($addresses);

        $identification_documents = [
            'identification' => $request->input('document_number'),
            'person_id' => $personId,
        ];
        DB::table('identification_documents')->insert($identification_documents);

        $phones = [
            'number' => $request->input('phone'),
            'phone_type' => $request->input('phone_type'),
            'person_id' => $personId,
        ];
        DB::table('phones')->insert($phones);

        $request->session()->put('person_id', $personId);
        return redirect('register');
    }
}
