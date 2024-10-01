<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class VideoRequest extends FormRequest
{
    // Authorization logic (set to true for allowing all authenticated users)
    public function authorize()
    {
        return true;
    }

    // Define the validation rules
    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'quiz_attempt_id' => 'required|integer|exists:quiz_attempts,id',  // Assuming you have a quiz_attempts table
            'video_url' => 'required|url',
        ];
    }

    // Custom error messages
    public function messages()
    {
        return [
            'title.required' => 'The title field is required.',
            'title.string' => 'The title must be a valid string.',
            'quiz_attempt_id.required' => 'You must provide a valid Quiz Attempt ID.',
            'quiz_attempt_id.exists' => 'The Quiz Attempt ID you provided does not exist.',
            'video_url.required' => 'The video URL is required.',
            'video_url.url' => 'Please provide a valid URL for the video.',
        ];
    }

    // Handle failed validation
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'errors' => $validator->errors()
        ], 422));
    }
}
