<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Answer;
use App\Models\Question;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersQuestionsAnswersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('users')->delete();
        DB::table('answers')->delete();
        DB::table('questions')->delete();

                \App\Models\User::factory(10)->create()->each(function($u) {
            $u->questions()
            ->saveMany(
                Question::factory()->count(rand(1,5))->make()
            )
            ->each(function($q){
                $q->answers()->saveMany(Answer::factory()->count(rand(1,5))->make());
            });
        });
    }
}
