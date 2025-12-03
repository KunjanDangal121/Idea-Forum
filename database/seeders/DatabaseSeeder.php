<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Idea;
use App\Models\Status;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. SETUP TOPICS (Formerly Statuses)
        // We delete existing ones to prevent duplicates and create your categories
        Status::truncate();

        Status::create(['name' => 'Science']);
        Status::create(['name' => 'Technology']);
        Status::create(['name' => 'Books']);
        Status::create(['name' => 'Movies']);
        Status::create(['name' => 'Art']);

        // 2. Create ADMIN User (Using your email for Admin checks)
        User::factory()->create([
            'name' => 'Kunjan',
            'email' => 'kunjandangal@gmail.com', // Matches your Admin Logic
            'password' => bcrypt('password'),
        ]);

        // 3. Create 10 other random users
        $users = User::factory(10)->create();

        // 4. Create 20 Ideas
        // We assign them a random Topic (Status ID 1 to 5)
        $ideas = Idea::factory(20)->recycle($users)->create(function () {
            return ['status_id' => rand(1, 5)];
        });

        // 5. Add random Comments
        foreach ($ideas as $idea) {
            Comment::factory(rand(0, 5))->create([
                'idea_id' => $idea->id,
                'user_id' => $users->random()->id,
            ]);
        }

        // 6. Add random Votes
        foreach ($ideas as $idea) {
            $voters = $users->random(rand(0, 5));
            $idea->votes()->attach($voters);
        }
    }
}
