<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\Products::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->realText($faker->numberBetween(10, 30)),
        'description' => $faker->paragraph($faker->numberBetween(1, 2)),
        'price' => $faker->randomFloat(2, 0.7, 400),
    ];
});

$factory->define(App\ProductImages::class, function (Faker\Generator $faker) {
    return [
        'path' => $faker->imageUrl(640, 480, 'food'),
        'order' => $faker->numberBetween(0, 20),
    ];
});

$factory->define(App\ProductOptions::class, function (Faker\Generator $faker) {
    $key = $faker->randomElement(['color', 'size']);
    
    switch ($key) {
        case 'color': $value = $faker->safeColorName(); break;
        case 'size': $value = $faker->randomElement(['small', 'regular', 'large', 'x-large']); break;
    }

    return [
        'value' => $value,
        'option' => $key,
    ];
});
