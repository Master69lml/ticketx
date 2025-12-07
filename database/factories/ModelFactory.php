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

$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'fullname' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => bcrypt($password ?: ($password = 'secret')),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Ticket::class, function (Faker\Generator $faker) {
    $startDate = \Carbon\Carbon::createFromDate(2023, 1, 1);
    $endDate = \Carbon\Carbon::now();

    return [
        'ticket_id' => strtoupper(str_random(10)),
        'user_id' => function () {
            return factory(App\User::class)->create()->id;
        },
        'category_id' => $faker->numberBetween(1, 6),
        'priority_id' => $faker->numberBetween(1, 3),
        'status_id' => $faker->randomElement([1, 2, 3, 4]),
        'title' => $faker->sentence(6),
        'message' => $faker->paragraph(4),
        'created_at' => $faker->dateTimeBetween($startDate, $endDate),
        'updated_at' => $faker->dateTimeBetween($startDate, $endDate),
    ];
});
