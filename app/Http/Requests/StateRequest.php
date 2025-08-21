<?php

namespace App\Http\Requests;

use App\Models\Country;
use App\Models\State;

class StateRequest
{
    public function rules(): array
    {
        return [
            'countryid' => [
                'required',
                'integer',
                $this->validCountryId()
            ],
            'name' => [
                'required',
                'string',
                'max:255',
                'min:2',
                $this->uniqueStateName()
            ],
            'status' => [
                'required',
                'integer',
                'in:0,1'
            ],
        ];
    }

    private function validCountryId()
    {
        return function ($attribute, $value, $fail) {
            if (!Country::where('id', $value)->where('status', 1)->exists()) {
                $fail('The selected country does not exist or is not active.');
            }
        };
    }

    private function uniqueStateName()
    {
        return function ($attribute, $value, $fail) {
            $stateId = request()->route('state') ? request()->route('state')->id : null;
            $countryId = request()->input('countryid');
            
            $query = State::where('name', $value)->where('countryid', $countryId);
            if ($stateId) {
                $query->where('id', '!=', $stateId);
            }
            
            if ($query->exists()) {
                $fail('The state name has already been taken in this country.');
            }
        };
    }
}