<?php

namespace App\Rules;

use App\Models\Country;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidCountryId implements ValidationRule
{
    protected $checkStatus;

    public function __construct($checkStatus = false)
    {
        $this->checkStatus = $checkStatus;
    }

    /**
     * Run the validation rule.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $query = Country::where('id', $value);
        
        if ($this->checkStatus) {
            $query->where('status', 1);
        }
        
        if (!$query->exists()) {
            if ($this->checkStatus) {
                $fail('The selected :attribute must be an active country.');
            } else {
                $fail('The selected :attribute does not exist.');
            }
        }
    }
}