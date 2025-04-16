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
        $roles = ['student', 'teacher', 'admin'];

        for ($i = 1; $i <= 10; $i++) {
            PortalUser::create([
                'Full_Name' => fake()->name(),
                'Age' => rand(18, 35),
                'Email' => fake()->unique()->safeEmail(),
                'Mobile_No' => fake()->phoneNumber(),
                'Address' => fake()->address(),
                'Institution' => fake()->company(),
                'Password' => Hash::make('password'), // Default password
                'Role' => $roles[array_rand($roles)],
                'Status' => 'active',
                'Course_Id' => null, // Or set if you want to link to a course
                'Profile_Picture' => null // Or use a fake image url if needed
            ]);
        }
    }
}
