<?php

use hala\Press\Post;

$factory->define(Post::class, function (Faker\Generator $faker) {
    return [
        'identifier' => \Illuminate\Support\Str::random(5),
        'slug' => $faker->sentence,
        'title' => $faker->sentence,
        'body' => $faker->paragraph,
        'extra' => json_encode(['test' => 'value']),
    ];
});

