<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CityRequest extends FormRequest
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
        $cityId = $this->route('city') ? $this->route('city')->id : null;
        
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                'min:2',
                Rule::unique('cities', 'name')
                    ->where('stateid', $this->input('stateid'))
                    ->ignore($cityId),
            ],
            'stateid' => [
                'required',
                'integer',
                'exists:states,id'
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
            'name.unique' => 'This city name already exists in the selected state.',
            'stateid.required' => 'State is required.',
            'stateid.integer' => 'State ID must be an integer.',
            'stateid.exists' => 'Selected state does not exist.',
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