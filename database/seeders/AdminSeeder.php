<?php

// namespace Database\Seeders;

// use App\Models\User;
// use Illuminate\Database\Seeder;
// use Illuminate\Support\Facades\Hash;

// class AdminSeeder extends Seeder
// {
    
//     public function run()
//     {
//         $admin = User::create([
//         'name' => 'Admin',
//         'email' => 'admin@admingmail.com',
//         'password' => Hash::make('admin@admin')
//     ]);

//     $admin->assignRole('admin');
//     }
// }
namespace Database\Seeders;



use Illuminate\Database\Seeder;

use App\Models\User;

use Illuminate\Support\Facades\Hash;

use Spatie\Permission\Models\Role;




class AdminSeeder extends Seeder



{
    public function run()

    {
        $adminRole = Role::where("name","admin")->first();

        if(!$adminRole) {

            $this->call(RolesAndPermissionsSeeder::class);
            $adminRole = Role::where("name","admin")->first();
        }
        $adminuser = User::updateOrCreate(

            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin',
                'password' => bcrypt('password@123'),
            ]
        );  

        // Assign role to the user with ID 1

        $user = User::find(1); 

        if ($user) {

            $user->assignRole('admin'); 

        }

               

    }



}



