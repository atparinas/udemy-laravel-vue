<?php

use Illuminate\Database\Seeder;
use App\Question;
use App\User;

class VotablesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('votables')->where('votable_type', 'App\Question')->delete();

        $users = User::all();
        $number_of_users = $users->count();
        $votes = [-1, 1];

        foreach(Question::all() as $question){

            for($i = 0; $i < rand(0, $number_of_users); $i++){

                $user = $users[$i];

                $user->voteQuestion($question, $votes[rand(0,1)]);

            }
        }
    }
}
