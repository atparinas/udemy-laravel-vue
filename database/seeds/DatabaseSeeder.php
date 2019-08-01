<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * 
     * running a sepecific seeder
     * php artisan db:seed --class=FavoritesTableSeeder 
     *
     * @return void
     */
    public function run()
    {

        $this->call([
            UsersQuestionsAnswersTableSeeder::class,
            FavoritesTableSeeder::class,
            VotablesTableSeeder::class
        ]);
        
    }
}
