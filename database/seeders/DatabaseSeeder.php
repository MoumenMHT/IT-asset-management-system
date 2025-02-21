<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Contract;
use App\Models\Employer;
use App\Models\Equipment;
use App\Models\Hostory;





class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Contract::factory()->count(10)->create();
        Employer::factory()->count(100)->create();
        Equipment::factory()->count(300)->create();
        Hostory::factory()->count(500)->create();


    }
}
