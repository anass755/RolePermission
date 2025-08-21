<?php

namespace App\Http\Requests;

use App\Models\Country;

class CountryRequest
{
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string', 
                'max:255',
                'min:2',
                $this->uniqueCountryName()
            ],
            'status' => [
                'required',
                'integer',
                'in:0,1'
            ],
        ];
    }

    private function uniqueCountryName()
    {
        return function ($attribute, $value, $fail) {
            $countryId = request()->route('country') ? request()->route('country')->id : null;
            
            $query = Country::where('name', $value);
            if ($countryId) {
                $query->where('id', '!=', $countryId);
            }
            
            if ($query->exists()) {
                $fail('The country name has already been taken.');
            }
        };
    }
}