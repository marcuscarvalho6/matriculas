<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Entities\Course;
use Faker\Generator as Faker;

$factory->define(Course::class, function (Faker $faker) {
    return [
        'title' => $faker->jobTitle(),
        'description' => $faker->text(200),
    ];
});
