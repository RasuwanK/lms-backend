<?php

namespace Database\Seeders;

use App\Models\Topic;
use App\Models\Module;
use Illuminate\Database\Seeder;

class TopicSeeder extends Seeder
{
    public function run()
    {
        // Ensure at least one module exists
        $moduleIds = Module::pluck('id')->toArray();

        if (empty($moduleIds)) {
            $this->command->warn("No modules found. Please seed modules first.");
            return;
        }

        $topics = [
            [
                'title' => 'Introduction to Programming',
                'description' => 'Basic programming concepts using Python.',
                'type' => 'Lecture',
                'is_visible' => true,
                'is_complete' => false,
            ],
            [
                'title' => 'Database Design',
                'description' => 'ER models, normalization, and SQL fundamentals.',
                'type' => 'Lecture',
                'is_visible' => true,
                'is_complete' => true,
            ],
            [
                'title' => 'Software Testing Techniques',
                'description' => 'Covers unit testing, integration testing, and automation tools.',
                'type' => 'Lecture',
                'is_visible' => true,
                'is_complete' => false,
            ]
        ];

        foreach ($topics as $topic) {
            Topic::create(array_merge($topic, [
                'module_id' => fake()->randomElement($moduleIds)
            ]));
        }
    }
}
