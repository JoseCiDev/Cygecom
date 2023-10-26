<?php

namespace App\Rules;

use Closure;
use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;

class UniqueCpfCnpj implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $existingUser = User::whereHas('person', function ($query) use ($value) {
            $query->where('cpf_cnpj', $value);
        })->first();

        if ($existingUser) {
            $fail('Desculpe, já existe um usuário cadastrado com esse CPF/CNPJ. Por favor, verifique o campo novamente');
        }
    }
}
