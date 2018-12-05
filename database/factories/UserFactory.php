<?php

use Faker\Generator as Faker;

$factory->define(App\Models\User::class, function (Faker $faker) {
    return [
        'username' => $faker->name ,
        'firstname' => $faker->firstName('male') ,
        'lastname' => $faker->lastName ,
        'email'    => $faker->email ,
        'gender'   => array_random(['male' , 'female']) ,
        'mobile'   => str_split($faker->phoneNumber , 11 )[0] ,
        'password' => bcrypt('secret') ,
        'remember_token' => str_random(10),
    ];
});
