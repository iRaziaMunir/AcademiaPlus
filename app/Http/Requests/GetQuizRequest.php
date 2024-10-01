<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GetQuizRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Update if you want authorization checks
    }

    public function rules()
    {
        return [
            'quizId' => 'required|integer|exists:quizzes,id',
        ];
    }

    public function messages()
    {
        return [
            'quizId.required' => 'The quiz ID is required.',
            'quizId.integer' => 'The quiz ID must be an integer.',
            'quizId.exists' => 'The quiz with the provided ID does not exist.',
        ];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        throw new \Illuminate\Validation\ValidationException($validator, response()->json([
            'message' => 'Validation failed',
            'errors' => $validator->errors()
        ], 422));
    }
}
