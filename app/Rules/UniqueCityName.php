<?php

namespace App\Rules;

use App\Models\City;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UniqueCityName implements ValidationRule
{
    protected $stateId;
    protected $ignoreId;

    public function __construct($stateId, $ignoreId = null)
    {
        $this->stateId = $stateId;
        $this->ignoreId = $ignoreId;
    }

    /**
     * Run the validation rule.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $query = City::where('name', $value)
                    ->where('stateid', $this->stateId);
        
        if ($this->ignoreId) {
            $query->where('id', '!=', $this->ignoreId);
        }
        
        if ($query->exists()) {
            $fail('The :attribute has already been taken in this state.');
        }
    }
}