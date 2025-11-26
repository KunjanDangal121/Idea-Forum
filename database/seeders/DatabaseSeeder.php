<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Idea;
use App\Models\User;
use Illuminate\Database\Seeder;
use Database\Seeders\StatusSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. CALL THE STATUS SEEDER FIRST!
        // This ensures the 'statuses' table is populated before we create any ideas.
        $this->call(StatusSeeder::class);


        // --- Existing User, Idea, Comment, and Vote Creation ---

        // 2. Create a specific Test User for YOU to login with
        $me = User::factory()->create([
            'name' => 'Kunjan',
            'email' => 'kunjan@example.com',
            'password' => bcrypt('password'),
        ]);

        // 3. Create 10 other random users
        $users = User::factory(10)->create();

        // 4. Create 20 Ideas, randomly assigned to the users we just created
        // NOTE: The status_id for these ideas will default to 1 ('Open').
        $ideas = Idea::factory(20)->recycle($users)->create();

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
