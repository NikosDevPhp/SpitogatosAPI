<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Listing;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Listing::class, function (Faker $faker) {
    return [
        'listing_id' => $faker->numberBetween(0, 10000),
        'location' => $faker->city,
        'square_meters' => $faker->numberBetween(0, 3000),
    ];
});
