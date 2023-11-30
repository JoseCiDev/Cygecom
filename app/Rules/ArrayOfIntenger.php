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
            $validIntenger = filter_var($item, FILTER_VALIDATE_INT);

            if (!$validIntenger && $validIntenger <= 0) {
                $fail('Cada item da lista deve corresponder a um número inteiro e maior que zero.');
            }
        }
    }
}
