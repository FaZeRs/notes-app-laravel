<?php

use App\Models\Comment;
use App\Models\Note;
use App\Models\User;
use Illuminate\Database\Seeder;

class DummyDataSeeder extends Seeder
{
    /**
     * Populate the database with dummy data for testing.
     * @param \Faker\Generator $faker
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        $users = factory(User::class, 25)->create();

        $users->each(function ($user) use ($faker) {
            $user->notes()
                ->saveMany(
                    factory(Note::class)
                        ->times($faker->numberBetween(1, 15))
                        ->make()
                )
                ->each(function ($note) use ($faker) {
                    $note->comments()
                        ->saveMany(
                            factory(Comment::class)
                                ->times($faker->numberBetween(1, 10))
                                ->make()
                        );
                });
        });
    }
}
