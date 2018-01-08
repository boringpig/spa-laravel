<?php

use Faker\Generator as Faker;

$factory->define(App\Article::class, function (Faker $faker) {
    $lang = ['zh-CN','zh-TW','en'];

    return [
        'title' => $faker->sentence(6),
        'content' => $faker->text(300),
        'language'  => $lang[mt_rand(0,2)],
    ];
});
