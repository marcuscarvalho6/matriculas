<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Entities\Student;
use Faker\Generator as Faker;

$factory->define(Student::class, function (Faker $faker) {
    $faker->addProvider(new \Faker\Provider\pt_BR\Person($faker));
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'gender' => $faker->randomElement($array = array ('M', 'F')),
        'date_of_birth' => $faker->dateTimeBetween('1980-01-01', '2010-12-31'),
    ];
});
