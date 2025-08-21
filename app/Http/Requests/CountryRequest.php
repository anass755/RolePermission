<?php

namespace App\Http\Requests;

use App\Models\Country;
use App\Rules\UniqueCountryName;
use App\Rules\ValidStatus;
use Illuminate\Foundation\Http\FormRequest;

class CountryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $countryId = $this->route('country') ? $this->route('country')->id : null;
        
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                'min:2',
                new UniqueCountryName($countryId),
            ],
            'status' => [
                'required',
                'integer',
                new ValidStatus(),
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
            'name.unique' => 'This country name already exists.',
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