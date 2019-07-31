<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Question;
use App\Answer;


class UsersQuestionsAnswersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Need to chain each method and pass in callback because question needs to be associated with user
        factory(User::class, 3)->create()->each(function($user){
            $user->questions()->saveMany(
                factory(Question::class, rand(1, 5))->make()
            )->each(function($question){
                $question->answers()->saveMany(
                    factory(Answer::class, rand(1,5))->make()
                );
            });
        });
    }
}
