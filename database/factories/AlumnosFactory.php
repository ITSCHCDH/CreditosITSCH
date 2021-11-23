<?php

use Faker\Generator as Faker;

$factory->define(App\Alumno::class, function (Faker $faker) {
    $id_carrera = $faker->randomElement($array = array(1,2,3,4,5,6,7));
    $iniciales = ["S","T","N","I","G","M","B",""];
    return [
        'nombre' => $faker->firstName($gender = null)." ".$faker->lastName." ".$faker->lastName,
        'status' => 'pendiente',
        'carrera' => $id_carrera,
        'no_control' => $iniciales[$id_carrera-1].$faker->randomElement($array = array("15","16","17","18")).$faker->numberBetween($min = 100101,$max = $max = 999999),
        'password' => bcrypt('sistemas'),
        'remember_token' => str_random(10),
    ];
});
