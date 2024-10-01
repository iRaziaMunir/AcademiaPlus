<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class AssignQuizRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // You can set authorization logic here.
        // For now, we'll return true so any authorized user can make this request.
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'quiz_id' => 'required|exists:quizzes,id',
            'student_id' => 'required|exists:users,id',  // Assuming students are in the users table
            'assigned_at' => 'required|date',
            'due_at' => 'required|date|after:assigned_at',
            'status'=>'required'
        ];
    }

    /**
     * Custom messages for validation errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'quiz_id.required' => 'The quiz ID is required.',
            'quiz_id.exists' => 'The selected quiz does not exist.',
            'student_id.required' => 'The student ID is required.',
            'student_id.exists' => 'The selected student does not exist.',
            'assigned_at.required' => 'The assignment date is required.',
            'assigned_at.date' => 'The assignment date must be a valid date.',
            'due_at.required' => 'The due date is required.',
            'due_at.date' => 'The due date must be a valid date.',
            'due_at.after' => 'The due date must be after the assignment date.',
            'status.required' => 'The status is required'
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     */
    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();

        // Throw a JSON response with the validation errors
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Validation failed',
            'errors' => $errors->messages(),
        ], 422)); // Unprocessable Entity
    }
}

