<?php

namespace App\Http\Requests;

use App\Models\City;
use App\Models\State;

class CityRequest
{
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                'min:2',
                $this->uniqueCityName()
            ],
            'stateid' => [
                'required',
                'integer',
                $this->validStateId()
            ],
            'status' => [
                'required',
                'integer',
                'in:0,1'
            ],
        ];
    }

    private function uniqueCityName()
    {
        return function ($attribute, $value, $fail) {
            $cityId = request()->route('city') ? request()->route('city')->id : null;
            $stateId = request()->input('stateid');
            
            $query = City::where('name', $value)->where('stateid', $stateId);
            if ($cityId) {
                $query->where('id', '!=', $cityId);
            }
            
            if ($query->exists()) {
                $fail('The city name has already been taken in this state.');
            }
        };
    }

    private function validStateId()
    {
        return function ($attribute, $value, $fail) {
            $stateExists = State::where('id', $value)
                               ->where('status', 1)
                               ->whereHas('country', function ($query) {
                                   $query->where('status', 1);
                               })
                               ->exists();
            
            if (!$stateExists) {
                $fail('The selected state does not exist or is not active, or belongs to an inactive country.');
            }
        };
    }
}