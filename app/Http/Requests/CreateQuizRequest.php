<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateQuizRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // You can set authorization logic here.
        // For now, we'll return true so any authenticated user can make this request.
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
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            // 'scheduled_at' => 'required|date',
            // 'expires_at' => 'required|date|after:scheduled_at',
            'scheduled_at' => 'required|date_format:Y-m-d H:i:s',
            'expires_at' => 'required|date_format:Y-m-d H:i:s',
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
            'title.required' => 'The quiz title is required.',
            'title.string' => 'The quiz title must be a valid string.',
            'scheduled_at.required' => 'The scheduled date is required.',
            'scheduled_at.date' => 'The scheduled date must be a valid date.',
            'expires_at.required' => 'The expiration date is required.',
            'expires_at.after' => 'The expiration date must be after the scheduled date.',
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
