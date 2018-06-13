<?php


$factory->define('App\Channel', function ($faker) {
    return[
        'name'   => $faker->word,
        'slug'   => $faker->word
    ];
});
