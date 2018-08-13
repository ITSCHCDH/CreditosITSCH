<?php

use Faker\Generator as Faker;

$factory->define(App\Alumno::class, function (Faker $faker) {
    return [
        'nombre' => $faker->firstName($gender = null)." ".$faker->lastName." ".$faker->lastName,
        'status' => 'pendiente',
        'carrera' => $faker->randomElement($array = array('Sistemas','Nanotecnología','Mecatrónica','Bioquímica',"TIC's",'Gestión Empresarial','Industrial')),
        'no_control' => $faker->randomElement($array = array("s","g","t","i","m","b","n","")).$faker->randomElement($array = array("15","16","17","18")).$faker->numberBetween($min = 100101,$max = $max = 999999),
        'password' => bcrypt('sistemas'),
        'remember_token' => str_random(10),
    ];
});
