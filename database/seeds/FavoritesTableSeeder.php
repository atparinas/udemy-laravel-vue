<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Question;

class FavoritesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        //Clear the Pivot Table
        \DB::table('favorites')->delete();

        $users = User::pluck('id')->all();
        $number_of_users = count($users);

        foreach(Question::all() as $question){

            for($i = 0; $i < rand(0, $number_of_users); $i++){
                $user = $users[$i];

                $question->favorites()->attach($user);
            }
        }


    }
}
