<?php

namespace Database\Seeders;

use App\Models\PortalUser;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PortalUserSeeder extends Seeder
{
    public function run()
    {
        $roles = ['student', 'lecturer', 'admin'];

        for ($i = 1; $i <= 10; $i++) {
            PortalUser::create([
                'Full_Name' => fake()->name(),
                'Age' => rand(18, 35),
                'Email' => fake()->unique()->safeEmail(),
                'Mobile_No' => fake()->numerify('07########'),
                'Address' => fake()->address(),
                'Password' => Hash::make('password'), // Default password
                'Role' => $roles[array_rand($roles)],
                'Status' => 1,
                'Course_Id' => null, // Or set if you want to link to a course
                'Profile_Picture' => null // Or use a fake image url if needed
            ]);
        }
            // The student that we are going to test
            PortalUser::create([
                'Full_Name' => 'Rasuwan Kalhara',
                'Age' => 21,
                'Email' => 'kalharaweragala@gmail.com',
                'Mobile_No' => '0705085269',
                'Address' => fake()->address(),
                'Password' => Hash::make('kalhara1234'), // Default password
                'Role' => 'student',
                'Status' => 1,
                'Course_Id' => 1, // Or set if you want to link to a course
                'Profile_Picture' => null // Or use a fake image url if needed
            ]);

            // The teacher that we are going to test
            // The student that we are going to test
            PortalUser::create([
                'Full_Name' => 'Kamal Perera',
                'Age' => 40,
                'Email' => 'kamalperera@gmail.com',
                'Mobile_No' => '0765385261',
                'Address' => fake()->address(),
                'Password' => Hash::make('kamal1234'), // Default password
                'Role' => 'lecturer',
                'Status' => 1,
                'Course_Id' => null, // Or set if you want to link to a course
                'Profile_Picture' => null // Or use a fake image url if needed
            ]);

            // This is the admin that we are going to test
            PortalUser::create([
                'Full_Name' => 'Sam Perera',
                'Age' => 46,
                'Email' => 'sam@gmail.com',
                'Mobile_No' => '0783453451',
                'Address' => fake()->address(),
                'Password' => Hash::make('kamal1234'), // Default password
                'Role' => 'admin',
                'Status' => 1,
                'Course_Id' => null, // Or set if you want to link to a course
                'Profile_Picture' => null // Or use a fake image url if needed
            ]);
    }
}
