<?php

namespace App\Http\Requests;

use App\Models\Country;
use App\Models\State;
use Illuminate\Validation\Rule;

class StateRequest
{
    public function rules(): array
    {
        return [
            'countryid' => [
                'required|integer',
                Rule::exists('countries', 'id')->where('status', 1)
            ],
            'name' => [
                'required|string|max:255|min:2',
                Rule::unique('states', 'name')->where('countryid', request()->input('countryid'))->ignore(request()->route('state'))
            ],
            'status' => 'required|integer|in:0,1',
        ];
    }
}