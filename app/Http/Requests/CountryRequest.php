<?php

namespace App\Http\Requests;

use App\Models\Country;
use Illuminate\Validation\Rule;

class CountryRequest
{
    public function rules(): array
    {
        $countryId = request()->route('country') ? request()->route('country')->id : null;
        
        return [
            'name' => [
                'required',
                'string', 
                'max:255',
                'min:2',
                Rule::unique('countries', 'name')->ignore($countryId)
            ],
            'status' => [
                'required',
                'integer',
                'in:0,1'
            ],
        ];
    }
}