<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuizAttemptRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'assignment_id' => 'required|exists:quiz_assignments,id',
            'student_id' => 'required|exists:users,id',
            'answers' => 'required|array|min:1',
            'answers.*.question_id' => 'required|exists:questions,id',
            'answers.*.selected_option' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'assignment_id.required' => 'Assignment ID is required.',
            'assignment_id.exists' => 'Invalid assignment ID.',
            'student_id.required' => 'Student ID is required.',
            'student_id.exists' => 'Invalid student ID.',
            'answers.required' => 'At least one answer is required.',
            'answers.array' => 'Answers must be an array.',
            'answers.*.question_id.required' => 'Each answer must have a question ID.',
            'answers.*.question_id.exists' => 'Invalid question ID.',
            'answers.*.selected_option.required' => 'Each answer must have a selected option.',
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
