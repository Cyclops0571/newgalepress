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

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'UserTypeID' => 111,
'CustomerID' => $faker->buildingNumber,
        'Username' => $faker->name,
        'FbUsername' => '',
        'Password' => $password ?: $password = bcrypt('secret'),
        'FirstName' => $faker->firstName,
        'LastName' => $faker->lastName,
        'Email' => $faker->email,
        'FbEmail' => '',
        'FbAccessToken' => '',
        'Timezone' => '1',
        'StatusID' => eStatus::Active,
    ];
});
