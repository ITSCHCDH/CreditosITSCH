<?php

namespace Database\Factories;

use App\Models\Alumno;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class AlumnoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Alumno::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $id_carrera = $this->faker->randomElement([1, 2, 3, 4, 5, 6, 7]);
        $iniciales = ["S", "T", "N", "I", "G", "M", "B", ""];
        
        return [
            'nombre' => $this->faker->firstName() . " " . $this->faker->lastName() . " " . $this->faker->lastName(),
            'status' => 'pendiente',
            'carrera' => $id_carrera,
            'no_control' => $iniciales[$id_carrera-1] . $this->faker->randomElement(["15", "16", "17", "18"]) . $this->faker->numberBetween(100101, 999999),
            'password' => bcrypt('sistemas'),
            'remember_token' => Str::random(10),
        ];
    }
}
