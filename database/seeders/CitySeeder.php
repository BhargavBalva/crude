<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;


class CitySeeder extends Seeder
{
    public function run(): void
    {
        City::insert([
            ['name' => 'Ahmedabad', 'state_id' => 1],
            ['name' => 'Surat', 'state_id' => 1],
            ['name' => 'Mumbai', 'state_id' => 2],
            ['name' => 'Pune', 'state_id' => 2],
            ['name' => 'Los Angeles', 'state_id' => 3],
            ['name' => 'San Francisco', 'state_id' => 3],
            ['name' => 'Houston', 'state_id' => 4],
            ['name' => 'Dallas', 'state_id' => 4],
        ]);
    }
}
