<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ArrayOfIntenger implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!is_array($value)) {
            $fail('O formato dos dados é inválido.');
        }

        foreach ($value as $item) {
            if (!is_int($item)) {
                $fail('Cada item na lista de habilidades deve ser um número inteiro.');
            }
        }
    }
}
