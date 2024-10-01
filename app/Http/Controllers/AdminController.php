<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddUserRequest;
use App\Http\Requests\PasswordSetupRequest;
use App\Http\Requests\FilterStudentRequest; // New request validation for student filtering
use App\DTOs\AddUserDTO; // Import DTO
use App\Helpers\ApiResponse;
use App\Models\User;
use App\Models\StudentSubmission;
use App\Services\AdminService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    protected $adminService;

    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }

    
    public function addUser(AddUserRequest $request)
    {
        Log::info('Adding user with role', $request->all());

        $validated = $request->validated();

        // Using DTO to encapsulate data transfer
        $addUserDTO = new AddUserDTO(
            $validated['name'],
            $validated['email'],
            $validated['role'],
            $validated['password'] ?? null
        );

        $response = $this->adminService->addUser($addUserDTO);

        return ApiResponse::success($response);
        // return response()->json($response);
    }

    public function setPassword(PasswordSetupRequest $request, $token)
    {
        Log::info('Attempting to set password for token: ' . $token);

        $response = $this->adminService->setPassword(trim($token), $request->password);

        return ApiResponse::success($response);
        // if(!$response)
        // {
        //     return ApiResponse::error('operation failed', 400);
        // }
        // return response()->json($response);
    }

    public function index(FilterStudentRequest $request)
    {
        $status = $request->input('status');

        Log::info('Filtering students by status: ' . $status);

        $students = StudentSubmission::when($status, function ($query, $status) {
            return $query->where('status', $status);
        })->get();

        return ApiResponse::success($students);

        // return response()->json($students);
    }
}

// namespace App\Http\Controllers;

// use App\Http\Requests\AddUserRequest;
// use App\Http\Requests\PasswordSetupRequest;
// use App\Http\Requests\FilterStudentRequest; // New request validation for student filtering
// use App\DTOs\AddUserDTO; // Import DTO
// use App\Models\User;
// use App\Models\StudentSubmission;
// use App\Services\AdminService;
// use Illuminate\Support\Facades\Hash;
// use Illuminate\Support\Facades\Log;
// use Illuminate\Http\Request;

// class AdminController extends Controller
// {
//     protected $adminService;

//     public function __construct(AdminService $adminService)
//     {
//         $this->adminService = $adminService;
//     }

//     // Add user with role
//     public function addUser(AddUserRequest $request)
//     {
//         Log::info('Adding user with role', $request->all());

//         $validated = $request->validated();

//         // Use DTO to encapsulate data transfer
//         $addUserDTO = new AddUserDTO(
//             $validated['name'],
//             $validated['email'],
//             $validated['role'],
//             $validated['password'] ?? null // optional password
//         );

//         $response = $this->adminService->addUser($addUserDTO);

//         return response()->json($response);
//     }

// public function setPassword(PasswordSetupRequest $request, $token)
// {
//     Log::info('Attempting to set password for token: ' . $token);

//     $response = $this->adminService->setPassword(trim($token), $request->password);

//     return response()->json($response);
// }

//     public function index(FilterStudentRequest $request)
//     {
//         $status = $request->input('status');

//         Log::info('Filtering students by status: ' . $status);

//         $students = StudentSubmission::when($status, function ($query, $status) {
//             return $query->where('status', $status);
//         })->get();

//         return response()->json($students);
//     }
// }



// namespace App\Http\Controllers;

// use App\Http\Requests\AddUserRequest;
// use App\Http\Requests\PasswordSetupRequest;
// use App\Models\StudentSubmission;
// use App\Services\AdminService;
// use App\Models\User;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Hash;
// use Illuminate\Support\Facades\Log;

// class AdminController extends Controller
// {
//     protected $adminService;

//     public function __construct(AdminService $adminService)
//     {
//         $this->adminService = $adminService;
//     }

//     // Add user with role
//     public function addUser(AddUserRequest $request)
//     {
//         $validated = $request->validated();  // Use validated data directly

//         $response = $this->adminService->addUser($validated);

//         return response()->json($response);
//     }

//     // Set Password using the token
//     public function setPassword(PasswordSetupRequest $request, $token)
//     {
//         // Find the user by the remember_token
//         $user = User::where('remember_token', $token)->first();

//         if (!$user) {
//             Log::error('Invalid token: ' . $token);
//             return response()->json([
//                 'success' => false,
//                 'message' => 'Invalid token.',
//             ], 400); // Bad Request
//         }

//         // Update the user's password and reset the remember_token
//         $user->update([
//             'password' => Hash::make($request->password),
//             'remember_token' => null, // Clear the token after password reset
//         ]);

//         Log::info("Password updated and token cleared for user: " . $user->email);

//         return response()->json([
//             'success' => true,
//             'message' => 'Password has been set successfully!',
//         ]);
//     }
//     // Function to filter and display students based on status
//         public function index(Request $request)
//         {
//             // Get the filter value from the request (status could be accepted, rejected, pending)
//             $status = $request->input('status');

//             // Use Eloquent ORM to fetch students based on the provided status
//             $students = StudentSubmission::when($status, function($query, $status) {
//                 return $query->where('status', $status);
//             })->get();

//             // Return the students data to the admin dashboard view
//             return response()->json($students);
//         }


// }
