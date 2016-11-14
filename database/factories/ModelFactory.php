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
| To run migrations refresh and seeding: php artisan migrate:refresh --seed
*/

$factory->define(App\Products::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->words($faker->numberBetween(2, 3), true),
        'description' => $faker->paragraph($faker->numberBetween(2, 5)),
        'price' => $faker->randomFloat(2, 0.7, 400),
        'discount' => $faker->randomElement([0, 5, 10, 15, 20]),
        'bundle' => $faker->randomElement([0, 1, 2]),
    ];
});

/*
 * Defines images seeder with random image generating (food).
 */
$factory->define(App\ProductImages::class, function (Faker\Generator $faker) {
    return [
        'path' => $faker->imageUrl(540, 300, 'food'),
        'order' => $faker->numberBetween(0, 20),
    ];
});

/*
 * Defines options seeder with random selection of the type of an option, and its value.
 */
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
