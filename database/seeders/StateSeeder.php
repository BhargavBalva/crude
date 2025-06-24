<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class StateSeeder extends Seeder
{
    public function run(): void
    {
        State::insert([
            ['name' => 'Gujarat', 'country_id' => 1],
            ['name' => 'Maharashtra', 'country_id' => 1],
            ['name' => 'California', 'country_id' => 2],
            ['name' => 'Texas', 'country_id' => 2],
        ]);
    }
}