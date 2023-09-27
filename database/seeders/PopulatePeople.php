<?php

namespace Database\Seeders;

use ErrorException;
use App\Models\Person;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;

class PopulatePeople extends SeederFromImporter
{
    /**
     * @throws ErrorException
     */
    public function runImporter(): void
    {
        $peopleData = $this->data;
        DB::transaction(function () use ($peopleData) {
            try {
                foreach ($peopleData as $data) {
                    $existingPerson = Person::where('cpf_cnpj', $data['cpf_cnpj'])->first();
                    if (!$existingPerson) {
                        $person = new Person;
                        $fillableData = array_intersect_key($data, array_flip($person->getFillable()));
                        $person->fill($fillableData);
                        $person->save();
                    } else {
                        Log::info('CPF duplicado encontrado: ' . $data['cpf_cnpj']);
                    }
                }
            } catch (QueryException $error) {
                DB::rollback();
                $msg = $error->getMessage();
                echo($msg);
                Log::error('Ocorreu um erro ao executar a transação: ' . $msg);
            }
        });
    }
}
