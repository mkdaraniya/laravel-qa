<?php

namespace Database\Seeders;

use Carbon\Factory;
use App\Models\Answer;
use App\Models\Question;
use Illuminate\Database\Seeder;
use Database\Seeders\VotablesTableSeeder;
use Database\Seeders\FavoritesTableSeeder;
use Database\Seeders\UsersQuestionsAnswersTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create()->each(function($u) {
        //     $u->questions()
        //     ->saveMany(
        //         Question::factory()->count(rand(1,5))->make()
        //     )
        //     ->each(function($q){
        //         $q->answers()->saveMany(Answer::factory()->count(rand(1,5))->make());
        //     });
        // });

        $this->call([
            UsersQuestionsAnswersTableSeeder::class,
            FavoritesTableSeeder::class,
            VotablesTableSeeder::class
        ]);
       
    }
}
