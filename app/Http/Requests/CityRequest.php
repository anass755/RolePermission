<?php

namespace App\Http\Requests;

use App\Models\City;
use App\Models\State;
use Illuminate\Validation\Rule;

class CityRequest
{
    public function rules(): array
    {
        return [
            'name' => [
                'required|string|max:255|min:2',
                Rule::unique('cities', 'name')->where('stateid', request()->input('stateid'))->ignore(request()->route('city'))
            ],
            'stateid' => [
                'required|integer',
                Rule::exists('states', 'id')->where('status', 1)->whereHas('country', function($query) {
                    $query->where('status', 1);
                })
            ],
            'status' => 'required|integer|in:0,1',
        ];
    }
}