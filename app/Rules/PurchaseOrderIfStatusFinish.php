<?php

namespace App\Rules;

use App\Enums\PurchaseRequestStatus;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class PurchaseOrderIfStatusFinish implements ValidationRule
{
    public function __construct(private ?string $status)
    {
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $isFinishedStatusRequest = $this->status === PurchaseRequestStatus::FINALIZADA->value;
        if (!$isFinishedStatusRequest && $value) {
            $fail('Desculpe, só é possível adicionar ordem de compra para solicitações finalizadas.');
        }
    }
}
