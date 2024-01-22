<?php

namespace App\Rules;

use App\Models\UserProfile;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ProfileType implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $profile = UserProfile::where('name', $value)->first();
        if (!$profile) {
            $fail('Esse perfil não existe no banco de dados!');
        }
    }
}
