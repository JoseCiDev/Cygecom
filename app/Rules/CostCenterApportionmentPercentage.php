<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CostCenterApportionmentPercentage implements ValidationRule
{
    public function __construct(private ?array $percentage, private ?array $currency)
    {
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $percentage = collect($this->percentage)->filter();
        $currency = collect($this->currency)->filter();

        if ($percentage->sum() !== 100) {
            $fail('A soma das porcentagens de rateio deve ser igual a 100%.');
        }

        if ($percentage->isNotEmpty() && $currency->isNotEmpty()) {
            $fail('Desculpe, não é possível ter rateio em porcentagem e em moeda simultaneamente.');
        }

        if (!is_numeric($value)) {
            $fail('O percentual de rateio deve ser um número.');
        }

        if ($value < 0) {
            $fail('Não é permitido porcentagem negativa.');
        }

        if ($value > 100) {
            $fail('A porcentagem possui valor máximo de 100%');
        }
    }
}
