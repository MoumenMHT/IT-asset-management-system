<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Hostory;
use App\Models\Equipment;
use App\Models\Employer;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Hostory>
 */
class HostoryFactory extends Factory
{
    protected $model = Hostory::class;

    public function definition(): array
    {
        return [
            'type' => $this->faker->randomElement(['assignment', 'restitution']),
            'id_employer' => Employer::inRandomOrder()->first()->id_employer ?? 1, 
            'id_equipement' => Equipment::inRandomOrder()->first()->id_equipement ?? 1, // Random existing equipment
            'status' => $this->faker->randomElement(['en attente', 'confirmer']),
            'path' => null, 
        ];
    }
}
