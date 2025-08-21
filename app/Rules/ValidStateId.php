<?php

namespace App\Rules;

use App\Models\State;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidStateId implements ValidationRule
{
    protected $checkStatus;
    protected $checkCountryStatus;

    public function __construct($checkStatus = false, $checkCountryStatus = false)
    {
        $this->checkStatus = $checkStatus;
        $this->checkCountryStatus = $checkCountryStatus;
    }

    /**
     * Run the validation rule.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $query = State::where('id', $value);
        
        if ($this->checkStatus) {
            $query->where('status', 1);
        }
        
        if ($this->checkCountryStatus) {
            $query->whereHas('country', function ($q) {
                $q->where('status', 1);
            });
        }
        
        if (!$query->exists()) {
            if ($this->checkStatus && $this->checkCountryStatus) {
                $fail('The selected :attribute must be an active state in an active country.');
            } elseif ($this->checkStatus) {
                $fail('The selected :attribute must be an active state.');
            } elseif ($this->checkCountryStatus) {
                $fail('The selected :attribute must belong to an active country.');
            } else {
                $fail('The selected :attribute does not exist.');
            }
        }
    }
}