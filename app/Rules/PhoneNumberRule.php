<?php

namespace App\Rules;

use Brick\PhoneNumber\PhoneNumber;
use Brick\PhoneNumber\PhoneNumberException;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class PhoneNumberRule implements ValidationRule
{
    public $implicit = true;
    
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if($value == "") return;

        try {
            $phone = PhoneNumber::parse($value, 'ID');

        } catch (PhoneNumberException $e) {
            
            $fail("Kolom :attribute harus berisi nomor telepon yang valid");

        }


    }
}
