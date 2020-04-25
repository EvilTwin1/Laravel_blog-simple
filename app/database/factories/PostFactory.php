<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Post;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    return [
        //
        'author_id' => rand(1,4),
        'title' => $faker->text($maxNbChars = 70),
        'short_title' => $faker->text($maxNbChars = 50),
        'descr' => $faker->text($maxNbChars = 200),
    ];
});
