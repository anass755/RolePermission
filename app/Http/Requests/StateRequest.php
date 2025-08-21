<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StateRequest extends FormRequest
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
        $stateId = $this->route('state') ? $this->route('state')->id : null;
        
        return [
            'countryid' => [
                'required',
                'integer',
                'exists:countries,id'
            ],
            'name' => [
                'required',
                'string',
                'max:255',
                'min:2',
                Rule::unique('states', 'name')
                    ->where('countryid', $this->input('countryid'))
                    ->ignore($stateId),
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
            'countryid.exists' => 'Selected country does not exist.',
            'name.required' => 'State name is required.',
            'name.string' => 'State name must be a string.',
            'name.max' => 'State name cannot exceed 255 characters.',
            'name.min' => 'State name must be at least 2 characters.',
            'name.unique' => 'This state name already exists in the selected country.',
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