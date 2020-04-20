<?php

/** @var Factory $factory */

use App\Channel;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Str;

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

$factory->define(App\User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
    ];
});


$factory->define(App\Thread::class, function (Faker $faker) {
    return [
        'user_id' => factory('App\User'),
        'channel_id' => factory(Channel::class),
        'title' => $faker->sentence,
        'body' => $faker->paragraph,
    ];
});


$factory->define(App\Reply::class, function (Faker $faker) {
    return [
        'thread_id' => factory('App\Thread'),
        'user_id' => factory('App\User'),
        'body' => $faker->paragraph,
    ];
});


$factory->define(Channel::class, function (Faker $faker) {

    $name = $faker->word;

    return [
        'name' => $name,
        'slug' => $name
    ];
});
