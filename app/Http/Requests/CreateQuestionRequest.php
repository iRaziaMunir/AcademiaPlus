<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateQuestionRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Allow all users to make this request
    }

    public function rules()
    {
        // Get options from the request
        $options = $this->input('options', []);

        return [
            'quiz_id' => 'required|exists:quizzes,id',
            'question_text' => 'required|string|max:255',
            'options' => 'required|array|min:2', // Ensure at least 2 options
            'options.*' => 'required|string|max:255', // Each option must be a string
            'correct_option' => 'required|string|in:' . implode(',', $options), // Must be one of the options
        ];
    }

    public function messages()
    {
        return [
            'quiz_id.required' => 'The quiz ID is required.',
            'quiz_id.exists' => 'The selected quiz does not exist.',
            'question_text.required' => 'The question text is required.',
            'options.required' => 'The options field is required.',
            'options.array' => 'The options must be an array.',
            'options.min' => 'There must be at least 2 options.',
            'options.*.required' => 'Each option is required.',
            'options.*.string' => 'Each option must be a string.',
            'correct_option.required' => 'The correct option is required.',
            'correct_option.in' => 'The correct option must be one of the provided options.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Validation failed',
            'errors' => $errors->messages(),
        ], 422));
    }
}
