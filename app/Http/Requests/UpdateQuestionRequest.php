<?php
namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Log;

class UpdateQuestionRequest extends FormRequest
{
    public function rules()
    {
        return [
            'quiz_id' => 'required|exists:quizzes,id',
            'question_text' => 'required|string|max:255',
            'options' => 'required|array|min:2',
            'correct_option' => 'required|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'quiz_id.required' => 'The quiz ID is required.',
            'quiz_id.exists' => 'The quiz ID must exist in the quizzes table.',
            'question_text.required' => 'The question text is required.',
            'options.required' => 'At least two options are required.',
            'correct_option.required' => 'The correct option is required.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        Log::error('Validation failed for question update', [
            'errors' => $validator->errors()->toArray(),
        ]);

        throw new HttpResponseException(
            response()->json([
                'message' => 'Validation failed.',
                'errors' => $validator->errors(),
            ], 422)
        );
    }
}
