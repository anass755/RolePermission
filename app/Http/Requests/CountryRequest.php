<?php

namespace App\Http\Requests;

use App\Models\Country;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CountryRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // Get country ID for update operations
        $countryId = $this->route('country') ? $this->route('country')->id : null;
        
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                'min:2',
                function ($attribute, $value, $fail) use ($countryId) {
                    $query = Country::where('name', $value);
                    if ($countryId) {
                        $query->where('id', '!=', $countryId);
                    }
                    if ($query->exists()) {
                        $fail('The country name has already been taken.');
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
            'name.required' => 'Country name is required.',
            'name.string' => 'Country name must be a string.',
            'name.max' => 'Country name cannot exceed 255 characters.',
            'name.min' => 'Country name must be at least 2 characters.',
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
            'name' => 'country name',
            'status' => 'status',
        ];
    }
}