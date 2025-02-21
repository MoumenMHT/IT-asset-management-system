<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Equipment;
use App\Models\Contract;
use App\Models\Provider;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Equipment>
 */
class EquipmentFactory extends Factory
{
    protected $model = Equipment::class;

    public function definition(): array
    {
        return [
            'id_contract' => Contract::inRandomOrder()->first()->id_contract ?? 1, // Random existing contract
            'Type' => $this->faker->randomElement(['Laptop', 'Printer', 'Monitor', 'Router', 'Server', 'Keyboard', 'PC', 'All in one']),
            'num_serie' => $this->faker->unique()->bothify('EQU-#####'), // Generates SN-12345
            'marque' => Provider::inRandomOrder()->first()->nom ?? 1,
            'etat' => $this->faker->randomElement(['New', 'Used']),
            'status' => $this->faker->randomElement(['disponible', 'indisponible']),
            'date_amortissement' => $this->faker->date(),
            'id_employer' => null, // Always NULL
        ];
    }
}
