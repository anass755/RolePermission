<?php

namespace App\Rules;

use App\Models\State;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UniqueStateName implements ValidationRule
{
    protected $countryId;
    protected $ignoreId;

    public function __construct($countryId, $ignoreId = null)
    {
        $this->countryId = $countryId;
        $this->ignoreId = $ignoreId;
    }

    /**
     * Run the validation rule.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $query = State::where('name', $value)
                     ->where('countryid', $this->countryId);
        
        if ($this->ignoreId) {
            $query->where('id', '!=', $this->ignoreId);
        }
        
        if ($query->exists()) {
            $fail('The :attribute has already been taken in this country.');
        }
    }
}