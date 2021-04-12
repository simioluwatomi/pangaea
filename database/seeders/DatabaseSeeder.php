<?php

namespace Database\Seeders;

use App\Models\Subscriber;
use App\Models\Topic;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Topic::factory()
            ->has(
                Subscriber::factory()->count(rand(10, 15)),
                'subscribers'
            )
            ->count(rand(15, 20))
            ->create();
    }
}
