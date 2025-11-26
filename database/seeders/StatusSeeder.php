<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusSeeder extends Seeder
{
    public function run(): void
    {
        // Define the core statuses for the forum
        $statuses = [
            ['name' => 'Open'],          // ID 1 (The default status)
            ['name' => 'Considering'],   // ID 2
            ['name' => 'In Progress'],   // ID 3
            ['name' => 'Implemented'],   // ID 4
            ['name' => 'Closed'],        // ID 5
        ];

        // Insert the statuses into the table
        DB::table('statuses')->insert($statuses);
    }
}
