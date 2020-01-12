<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Task;
use Faker\Generator as Faker;

$factory->define(Task::class, function (Faker $faker) {
    
    return [
        'title' => $faker->unique()->sentence,
        'body' => $faker->text,
        'author_id' => rand(1,3)
    ];

});
