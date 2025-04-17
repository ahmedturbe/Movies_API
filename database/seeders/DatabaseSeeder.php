<?php

namespace Database\Seeders;

use App\Models\Actor;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Movie;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        // Create Actors
        Actor::factory()->count(5)->create()->each(function ($actor) {
            $actor->image()->create([
                'path' => fake()->imageUrl()
            ]);
        });

        // Create Movies
        Movie::factory()->count(5)->create()->each(function ($movie) {
            $movie->image()->create([
                'path' => fake()->imageUrl()
            ]);
        });
        //Create Users
        User::factory()->count(5)->create()->each(function ($user) {
            $user->interactions()->create([
                'interactable_id' => Movie::factory(),
                'interactable_type' => Movie::class,
                'type' => fake()->randomElement(['favorite', 'follow']),
            ]);
            //Assign Actors to Movies



        });
    }
}
