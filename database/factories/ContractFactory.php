<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Contract;
use App\Models\Structure;
use App\Models\Provider;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contract>
 */
class ContractFactory extends Factory
{
    protected $model = Contract::class;

    public function definition(): array
    {
        return [
            'ref' => $this->faker->unique()->bothify('CNT-###'), // Generates CNT-123
            'date_acquisition' => $this->faker->date(),
            'garantie' => $this->faker->date(),
            'Type_contract' => $this->faker->randomElement(['Maintenance', 'Achat']),
            'id_structure' => Structure::inRandomOrder()->first()->id_structure ?? 1, // Random existing structure
            'id_fournisseur' => Provider::inRandomOrder()->first()->id_fournisseur ?? 1, // Random existing provider
        ];
    }
}
