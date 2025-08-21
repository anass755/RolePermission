<?php

namespace App\Http\Requests;

use App\Models\City;
use App\Models\State;
use Illuminate\Foundation\Http\FormRequest;

class CityRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // Get city ID for update operations
        $cityId = $this->route('city') ? $this->route('city')->id : null;
        
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                'min:2',
                function ($attribute, $value, $fail) use ($cityId) {
                    $query = City::where('name', $value)
                                ->where('stateid', $this->input('stateid'));
                    if ($cityId) {
                        $query->where('id', '!=', $cityId);
                    }
                    if ($query->exists()) {
                        $fail('The city name has already been taken in this state.');
                    }
                },
            ],
            'stateid' => [
                'required',
                'integer',
                function ($attribute, $value, $fail) {
                    $stateExists = State::where('id', $value)
                                       ->where('status', 1)
                                       ->whereHas('country', function ($query) {
                                           $query->where('status', 1);
                                       })
                                       ->exists();
                    
                    if (!$stateExists) {
                        $fail('The selected state does not exist or is not active, or belongs to an inactive country.');
                    }
                },
            ],
            'status' => [
                'required',
                'integer',
                'in:0,1'
            ],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'City name is required.',
            'name.string' => 'City name must be a string.',
            'name.max' => 'City name cannot exceed 255 characters.',
            'name.min' => 'City name must be at least 2 characters.',
            'stateid.required' => 'State is required.',
            'stateid.integer' => 'State ID must be an integer.',
            'status.required' => 'Status is required.',
            'status.integer' => 'Status must be an integer.',
            'status.in' => 'Status must be either 0 (disabled) or 1 (enabled).',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'name' => 'city name',
            'stateid' => 'state',
            'status' => 'status',
        ];
    }
}