<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class projectRequestsRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'search' => ['nullable', 'string', 'max:50'],
            'system_type' => ['nullable', 'integer' , 'exists:system_types,id'],
            'status' => ['nullable', 'string', 'in:pending,completed'],

            // If start_date is present, end_date must be present too
            'start_date' => [
                'nullable',
                'required_with:end_date',
                'date_format:Y-m-d'
            ],

            // If end_date is present, start_date must be present too
            'end_date'   => [
                'nullable',
                'required_with:start_date',
                'date_format:Y-m-d',
                'after_or_equal:start_date' // Ensures end_date is chronologically after start_date
            ],
        ];
    }
}
