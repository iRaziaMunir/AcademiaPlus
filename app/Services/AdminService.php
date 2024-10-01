<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Str;
use App\DTOs\AddUserDTO;
use App\Notifications\PasswordSetup;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Spatie\Permission\Models\Role;

class AdminService
{
    // Add a user with dynamic role (admin, manager, supervisor, student)
    public function addUser(AddUserDTO $addUserDTO)
    {
        DB::beginTransaction();

        try {
            // Use provided password or generate a random one
            $password = $addUserDTO->password ?? Str::random(8);
            $passwordToken = Str::random(60);

            Log::info("Generated password token: $passwordToken for user: " . $addUserDTO->email);

            // Create a new user
            $user = User::create([
                'name' => $addUserDTO->name,
                'email' => $addUserDTO->email,
                'password' => Hash::make($password),
                'remember_token' => $passwordToken,
            ]);

            Log::info('User created with token stored in the database: ' . $user->remember_token);

            // Find and assign the role dynamically
            $role = Role::findByName($addUserDTO->role, 'api');

            if (!$role) {
                Log::error("Role {$addUserDTO->role} not found for user: " . $addUserDTO->email);
                DB::rollBack();
                return ['success' => false, 'message' => ucfirst($addUserDTO->role) . ' role not found'];
            }

            $user->assignRole($role);

            // Send notification for password setup
            Notification::send($user, new PasswordSetup($passwordToken));

            Log::info("Password setup notification sent to user: " . $addUserDTO->email);

            DB::commit();

            return ['success' => true, 'message' => ucfirst($addUserDTO->role) . ' added successfully and password setup notification sent'];

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in addUser: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Failed to add user or send password setup notification'];
        }
    }

    // Set password for the user using a token
    public function setPassword(string $token, string $newPassword)
    {
        DB::beginTransaction();

        try {
            // Find the user by the remember_token
            $user = User::where('remember_token', $token)->first();

            if (!$user) {
                Log::error('Invalid token: ' . $token);
                return ['success' => false, 'message' => 'Invalid token.'];
            }

            // Update the user's password and reset the remember_token
            $user->update([
                'password' => Hash::make($newPassword),
                'remember_token' => null, // Clear the token after password reset
            ]);

            Log::info("Password updated and token cleared for user: " . $user->email);

            DB::commit();

            return ['success' => true, 'message' => 'Password has been set successfully!'];

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in setPassword: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Failed to set password.'];
        }
    }
}


// namespace App\Services;

// use App\Models\User;
// use Illuminate\Support\Str;
// use App\DTOs\AddUserDTO;
// use App\Notifications\PasswordSetup;
// use Illuminate\Support\Facades\DB;
// use Illuminate\Support\Facades\Hash;
// use Illuminate\Support\Facades\Log;
// use Illuminate\Support\Facades\Notification;
// use Spatie\Permission\Models\Role;

// class AdminService
// {
//     // Add a user with dynamic role (admin, manager, supervisor, student)
//     public function addUser(AddUserDTO $addUserDTO)
//     {
//         DB::beginTransaction();

//         try {
//             // Use provided password or generate a random one
//             $password = $addUserDTO->password ?? Str::random(8);
//             $passwordToken = Str::random(60);

//             Log::info("Generated password token: $passwordToken for user: " . $addUserDTO->email);

//             // Create a new user
//             $user = User::create([
//                 'name' => $addUserDTO->name,
//                 'email' => $addUserDTO->email,
//                 'password' => Hash::make($password),
//                 'remember_token' => $passwordToken,
//             ]);

//             Log::info('User created with token stored in the database: ' . $user->remember_token);

//             // Find and assign the role dynamically
//             $role = Role::findByName($addUserDTO->role, 'api');

//             if (!$role) {
//                 Log::error("Role {$addUserDTO->role} not found for user: " . $addUserDTO->email);
//                 DB::rollBack();
//                 return ['success' => false, 'message' => ucfirst($addUserDTO->role) . ' role not found'];
//             }

//             $user->assignRole($role);

//             // Send notification for password setup
//             Notification::send($user, new PasswordSetup($passwordToken));

//             Log::info("Password setup notification sent to user: " . $addUserDTO->email);

//             DB::commit();

//             return ['success' => true, 'message' => ucfirst($addUserDTO->role) . ' added successfully and password setup notification sent'];

//         } catch (\Exception $e) {
//             DB::rollBack();
//             Log::error('Error in addUser: ' . $e->getMessage());
//             return ['success' => false, 'message' => 'Failed to add user or send password setup notification'];
//         }
//     }

//     // Set password for the user using a token
//     public function setPassword(string $token, string $newPassword)
//     {
//         DB::beginTransaction();

//         try {
//             // Find the user by the remember_token
//             $user = User::where('remember_token', $token)->first();

//             if (!$user) {
//                 Log::error('Invalid token: ' . $token);
//                 return ['success' => false, 'message' => 'Invalid token.'];
//             }

//             // Update the user's password and reset the remember_token
//             $user->update([
//                 'password' => Hash::make($newPassword),
//                 'remember_token' => null, // Clear the token after password reset
//             ]);

//             Log::info("Password updated and token cleared for user: " . $user->email);

//             DB::commit();

//             return ['success' => true, 'message' => 'Password has been set successfully!'];

//         } catch (\Exception $e) {
//             DB::rollBack();
//             Log::error('Error in setPassword: ' . $e->getMessage());
//             return ['success' => false, 'message' => 'Failed to set password.'];
//         }
//     }
// }

// namespace App\Services;

// use App\Models\User;
// use Illuminate\Support\Str;
// use App\DTOs\AddUserDTO;
// use App\Notifications\PasswordSetup;
// use Illuminate\Support\Facades\DB;
// use Illuminate\Support\Facades\Hash;
// use Illuminate\Support\Facades\Log;
// use Illuminate\Support\Facades\Notification;
// use Spatie\Permission\Models\Role;

// class AdminService
// {
//     // Add a user with dynamic role (admin, manager, supervisor, student)
//     public function addUser(AddUserDTO $addUserDTO)
//     {
//         DB::beginTransaction();

//         try {
//             // Use provided password or generate a random one
//             $password = $addUserDTO->password ?? Str::random(8);
//             $passwordToken = Str::random(60);

//             Log::info("Generated password token: $passwordToken for user: " . $addUserDTO->email);

//             // Create a new user
//             $user = User::create([
//                 'name' => $addUserDTO->name,
//                 'email' => $addUserDTO->email,
//                 'password' => Hash::make($password),
//                 'remember_token' => $passwordToken,
//             ]);

//             Log::info('User created with token stored in the database: ' . $user->remember_token);

//             // Find and assign the role dynamically
//             $role = Role::findByName($addUserDTO->role, 'api');

//             if (!$role) {
//                 Log::error("Role {$addUserDTO->role} not found for user: " . $addUserDTO->email);
//                 DB::rollBack();
//                 return ['success' => false, 'message' => ucfirst($addUserDTO->role) . ' role not found'];
//             }

//             $user->assignRole($role);

//             // Send notification for password setup
//             Notification::send($user, new PasswordSetup($passwordToken));

//             Log::info("Password setup notification sent to user: " . $addUserDTO->email);

//             DB::commit();

//             return ['success' => true, 'message' => ucfirst($addUserDTO->role) . ' added successfully and password setup notification sent'];

//         } catch (\Exception $e) {
//             DB::rollBack();
//             Log::error('Error in addUser: ' . $e->getMessage());
//             return ['success' => false, 'message' => 'Failed to add user or send password setup notification'];
//         }
//     }
// }



// namespace App\Services;

// use App\Models\User;
// use App\Notifications\PasswordSetup;
// use Illuminate\Support\Facades\DB;
// use Illuminate\Support\Facades\Hash;
// use Illuminate\Support\Str;
// use Spatie\Permission\Models\Role;
// use Illuminate\Support\Facades\Log;
// use Illuminate\Support\Facades\Notification;

// class AdminService
// {
//     // Add a user with dynamic role (admin, manager, supervisor, student)
//     public function addUser(array $validated)
// {
//     // Begin a database transaction for safety
//     DB::beginTransaction();

//     try {
//         // Generate password or use the provided one
//         $password = $validated['password'] ?? Str::random(8);
//         $passwordToken = Str::random(60);

//         // Log the generated token
//         Log::info("Generated password token: $passwordToken for user: " . $validated['email']);

//         // Create a new user with password and token
//         $user = User::create([
//             'name' => $validated['name'],
//             'email' => $validated['email'],
//             'password' => Hash::make($password),
//             'remember_token' => $passwordToken,  // Ensure token is stored in the database
//         ]);

//         // Log confirmation of the token stored in the database
//         Log::info('User created with token stored in the database: ' . $user->remember_token);

//         // Ensure the token was actually saved (just for debug)
//         if (is_null($user->remember_token)) {
//             throw new \Exception('Failed to save remember_token for user: ' . $user->email);
//         }

//         // Find and assign the role dynamically based on the request
//         $role = Role::findByName($validated['role'], 'api');

//         if (!$role) {
//             Log::error("Role {$validated['role']} not found for user: " . $validated['email']);
//             DB::rollBack(); // Roll back the transaction
//             return ['success' => false, 'message' => ucfirst($validated['role']) . ' role not found'];
//         }

//         // Assign the role to the user
//         $user->assignRole($role);

//         // Send notification for password setup
//         Notification::send($user, new PasswordSetup($passwordToken));
//         Log::info("Password setup notification sent to user: " . $validated['email']);

//         // Commit the transaction if everything works
//         DB::commit();

//         return ['success' => true, 'message' => ucfirst($validated['role']) . ' added successfully and password setup notification sent'];

//     } catch (\Exception $e) {
//         // Rollback transaction on failure
//         DB::rollBack();
//         Log::error('Error in addUser: ' . $e->getMessage());
//         return ['success' => false, 'message' => 'Failed to add user or send password setup notification'];
//     }
// }
// } 
