<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Employer;
use App\Models\Structure;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employer>
 */
class EmployerFactory extends Factory
{
    protected $model = Employer::class;

    public function definition(): array
    {
        return [
            'nom' => $this->faker->lastName(),
            'prenom' => $this->faker->firstName(),
            'fonc' => $this->faker->jobTitle(),
            'code' => $this->faker->unique()->bothify('EMP-####'), // Generates EMP-1234
            'id_structure' => Structure::inRandomOrder()->first()->id_structure ?? 1, // Random existing structure
            'id_user' => null, // Always NULL
        ];
    }
}
