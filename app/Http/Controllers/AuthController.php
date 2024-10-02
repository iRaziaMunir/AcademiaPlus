<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Exception;

class AuthController extends Controller
{
    public $token = true;

    public function register(RegisterRequest $request)
    {
        // Create a new user
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        // Return success response without token
        return ApiResponse::success($user, 'User registered successfully', Response::HTTP_OK);
    }

    public function login(LoginRequest $request)
    {
    // dd('I am from login');
    $input = $request->only('email', 'password');

    // Attempt to authenticate the user
    if (!$jwt_token = JWTAuth::attempt($input)) {
        return ApiResponse::error('Invalid Email or Password', 401);
    }

    // Get authenticated user
    $user = Auth::user();

    $role = $user->getRoleNames(); // Returns a collection of role names

    if ($user->student_id) {
        $studentId = $user->student_id;  // You have the student_id
    } else {
        $studentId = null;  // Not a student, maybe a manager or supervisor
    }

    if($studentId !== null && $role->contains('student'))
    {
        $responseData = [
        
                'studentId' => $studentId,
                'name' => $user->name,
                'role' => $role
        ];
    }
    else
    {
        $responseData = [
        
            'name' => $user->name,
            'role' => $role
    ];
    }
    return ApiResponse::success(
       $responseData,
        'Login successful',
        200,
        $jwt_token,                        // JWT Token
        'Bearer',                          // Token type
        JWTAuth::factory()->getTTL() * 60  // Token expiry time in seconds
    );
    }

    public function logout()
    {
        try {
            // Invalidate the token
            JWTAuth::invalidate(JWTAuth::parseToken());

            return ApiResponse::success([], 'User logged out successfully', Response::HTTP_OK);
        } catch (JWTException $exception) {
            return ApiResponse::error('Sorry, the user cannot be logged out', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getUser()
    {
        try {
            // Authenticate the token and retrieve the user
            $user = JWTAuth::authenticate(request()->token);
            
            $jwt_token = $user->token;
            $roles = $user->getRoleNames(); // This will get the role names of the user
             $permissions = $user->getAllPermissions(); // This will get all permissions of the user

            return response()->json([

                "message" => "Login successful",
                "data" => [
                    // "token" => [
                    //     "access_token" => $jwt_token,
                    //     "token_type" => "bearer",
                    //     "expires_in" => JWTAuth::factory()->getTTL() * 60, // Expiry time in seconds
                    // ],

                    "role" => $roles, // List of roles

                    "permissions" => $permissions->map(function ($permission) {

                        return [
                            "id" => $permission->id,
                            "name" => $permission->name
                        ];
                    }),
                ]
            ]);
            // return ApiResponse::success($user, 'User data retrieved successfully', Response::HTTP_OK);
        } catch (Exception $e) {
            return ApiResponse::error('Something went wrong', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
