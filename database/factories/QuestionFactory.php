<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Model;
use Faker\Generator as Faker;
use App\Question;

$factory->define(Question::class, function (Faker $faker) {

    //rtrim will just remove the "." at that end of sentence
    //paragraph alway returns an array. "true" parameter will make this a paragraph with \n separator

    return [
        'title' => rtrim($faker->sentence(rand(5, 10)), "."),
        'body' => $faker->paragraphs(rand(3, 7), true),
        'views' => rand(0, 10),
        // 'answers_count' => rand(0, 10),
        // 'votes_count' => rand(-3, 10)
    ];
});
