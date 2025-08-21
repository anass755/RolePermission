<?php

namespace App\Http\Requests;

use App\Models\Country;
use App\Models\State;
use Illuminate\Foundation\Http\FormRequest;

class StateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // Get state ID for update operations
        $stateId = $this->route('state') ? $this->route('state')->id : null;
        
        return [
            'countryid' => [
                'required',
                'integer',
                function ($attribute, $value, $fail) {
                    if (!Country::where('id', $value)->where('status', 1)->exists()) {
                        $fail('The selected country does not exist or is not active.');
                    }
                },
            ],
            'name' => [
                'required',
                'string',
                'max:255',
                'min:2',
                function ($attribute, $value, $fail) use ($stateId) {
                    $query = State::where('name', $value)
                                 ->where('countryid', $this->input('countryid'));
                    if ($stateId) {
                        $query->where('id', '!=', $stateId);
                    }
                    if ($query->exists()) {
                        $fail('The state name has already been taken in this country.');
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
            'countryid.required' => 'Country is required.',
            'countryid.integer' => 'Country ID must be an integer.',
            'name.required' => 'State name is required.',
            'name.string' => 'State name must be a string.',
            'name.max' => 'State name cannot exceed 255 characters.',
            'name.min' => 'State name must be at least 2 characters.',
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
            'countryid' => 'country',
            'name' => 'state name',
            'status' => 'status',
        ];
    }
}