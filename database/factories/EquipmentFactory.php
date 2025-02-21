<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Equipment;
use App\Models\Contract;
use App\Models\Provider;
use App\Models\Employer; // Assuming this is the user model for employees

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Equipment>
 */
class EquipmentFactory extends Factory
{
    protected $model = Equipment::class;

    public function definition(): array
    {
        $status = $this->faker->randomElement(['disponible', 'indisponible']);
        $contract = Contract::inRandomOrder()->first();

        return [
            'id_contract' => $contract->id_contract, // Now selects a random contract
            'Type' => $this->faker->randomElement(['Laptop', 'Printer', 'Monitor', 'Router', 'Server', 'Keyboard', 'PC', 'All in one']),
            'num_serie' => $this->faker->unique()->bothify('EQU-#####'), // Generates SN-12345
            'marque' => Provider::inRandomOrder()->first()->nom ?? 1,
            'etat' => $this->faker->randomElement(['New', 'Used']),
            'status' => $status,
            'date_amortissement' => $this->faker->date(),
            'id_employer' => $status === 'indisponible' ? Employer::inRandomOrder()->first()->id_employer ?? 606 : null,
        ];
    }
}
