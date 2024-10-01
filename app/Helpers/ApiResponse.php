<?php

namespace App\Helpers;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ApiResponse
{
    /**
     * Success response method.
     *
     * @param mixed $data
     * @param string $message
     * @param int $statusCode
     * @param string|null $token
     * @param string $tokenType
     * @param int|null $expiresIn
     * @param string|null $role
     * @param array $permissions
     * @return \Illuminate\Http\JsonResponse
     */
    public static function success(
        $data = null,
        $message = 'Operation successful',
        $statusCode = 200,
        $token = null,
        $tokenType = 'Bearer',
        $expiresIn = null,
        $role = null,
        $permissions = []
    ) {
        // Initialize the response structure
        $response = [
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ];

        // If token is provided, add token details to response
        if ($token) {
            $response['token'] = [
                'access_token' => $token,
                'token_type' => $tokenType,
                'expires_in' => $expiresIn,
            ];
        }

        // If role is provided, add user role to response
        if ($role) {
            $response['role'] = $role;
        }

        // If permissions are provided, add permissions to response
        if (!empty($permissions)) {
            $response['permissions'] = $permissions;
        }

        return response()->json($response, $statusCode);
    }

    /**
     * Error response method.
     *
     * @param string $message
     * @param int $statusCode
     * @param mixed|null $data
     * @return \Illuminate\Http\JsonResponse
     */
    public static function error($message , $statusCode,)
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            // 'data' => $data
        ], $statusCode);
    }

    /**
     * Validation error response.
     *
     * @param Validator $validator
     * @return void
     * @throws HttpResponseException
     */
    public static function validationError(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'status' => 'error',
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422)
        );
    }

    /**
     * Exception error handler.
     *
     * @param \Exception $exception
     * @return \Illuminate\Http\JsonResponse
     */
    public static function exception($exception)
    {
        return response()->json([
            'status' => 'error',
            'message' => $exception->getMessage(),
            'code' => $exception->getCode()
        ], 500);
    }
}
