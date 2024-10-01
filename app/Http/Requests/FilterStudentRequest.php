<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FilterStudentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'status' => 'nullable|string|in:accepted,rejected,pending', // Accept only valid statuses
        ];
    }

    public function messages()
    {
        return [
            'status.in' => 'The status must be one of the following: accepted, rejected, or pending.',
            'status.string' => 'The status must be a string.',
        ];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $response = response()->json([
            'errors' => $validator->errors(),
        ], 422);

        throw new \Illuminate\Validation\ValidationException($validator, $response);
    }
}
