<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create roles if they don't already exist
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $supervisorRole = Role::firstOrCreate(['name' => 'supervisor']);
        $managerRole = Role::firstOrCreate(['name' => 'manager']);
        $studentRole = Role::firstOrCreate(['name' => 'student']);

        // Define permissions
        $permissions = [
            'user can add users',
            'user can delete users',
            'user can view students',
            'user can view managers',
            'user can view supervisors',
            'user can accept student submission request',
            'user can reject student submission request',
            'user can create quiz',
            'user can update quiz',
            'user can delete quiz',
            'user can assign quiz',
            'user can view all quizzes',
            'user can attempt assigned quizzes',
            'user can view assigned quizzes',
            'user can view quizzes results',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Assign permissions to roles
        $adminRole->givePermissionTo([
            'user can add users',
            'user can delete users',
            'user can view students',
            'user can view managers',
            'user can view supervisors',
            'user can accept student submission request',
            'user can reject student submission request',
            'user can create quiz',
            'user can update quiz',
            'user can delete quiz',
            'user can assign quiz',
            'user can view all quizzes',
            'user can view assigned quizzes',
            'user can view quizzes results',
        ]);

        $supervisorRole->givePermissionTo([
            'user can view students',
            'user can create quiz',
            'user can update quiz',
            'user can delete quiz',
            'user can assign quiz',
            'user can view all quizzes',]);

        $managerRole->givePermissionTo([
            'user can view students',
            'user can create quiz',
            'user can update quiz',
            'user can delete quiz',
            'user can assign quiz',
            'user can view all quizzes',]);

        $studentRole->givePermissionTo([
            'user can view all quizzes',
            'user can view assigned quizzes',
            'user can view quizzes results',
            'user can attempt assigned quizzes',
        ]);
    }
}
