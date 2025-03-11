<?php

namespace Database\Seeders;

use App\Models\PortalUser;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PortalUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PortalUser::factory()->count(3)->create();
    }
}
