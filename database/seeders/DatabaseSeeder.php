<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Idea;
use App\Models\Comment;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create a specific Test User for YOU to login with
        $me = User::factory()->create([
            'name' => 'Kunjan',
            'email' => 'kunjan@example.com',
            'password' => bcrypt('password'), // Password is 'password'
        ]);

        // 2. Create 10 other random users
        $users = User::factory(10)->create();

        // 3. Create 20 Ideas, randomly assigned to the users we just created
        $ideas = Idea::factory(20)->recycle($users)->create();

        // 4. Add random Comments
        foreach ($ideas as $idea) {
            Comment::factory(rand(0, 5))->create([
                'idea_id' => $idea->id,
                'user_id' => $users->random()->id,
            ]);
        }

        // 5. Add random Votes
        // We loop through ideas and have random users vote on them
        foreach ($ideas as $idea) {
            // Get a random chunk of users (between 0 and 5 users)
            $voters = $users->random(rand(0, 5));
            
            // Attach these users to the idea as voters
            // (This relies on the 'votes' relationship we added to the Idea model)
            $idea->votes()->attach($voters);
        }
    }
}
