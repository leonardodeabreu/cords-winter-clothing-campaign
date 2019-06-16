<?php

use App\Api\User\Models\UserModel;
use App\Api\User\Repositories\UserRepository;
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

$factory->define(UserModel::class, function (Faker $faker) {
    $user = (new UserRepository())->findBy('email', 'cords@db1.com.br');

    if ($user) {
        return [
            'name'           => $user->name,
            'email'          => $user->email,
            'password'       => $user->password,
            'active'         => $user->active,
            'remember_token' => $user->remember_token,
        ];
    }

    return [
        'name'           => $faker->name,
        'email'          => $faker->unique()->safeEmail,
        'password'       => config('app.key'),
        'active'         => 1,
        'remember_token' => str_random(10),
    ];
});
