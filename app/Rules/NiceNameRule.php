<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class NiceNameRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if(!preg_match("/^[a-zA-Z']{3,}( {1,2}[a-zA-Z']{3,}){0,}$/", $value))
        {
            $fail('Kolom :attribute harus mengandung nama yang valid');
        }
    }
}
