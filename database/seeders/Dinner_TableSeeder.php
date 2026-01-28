<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\DinnerTable;

class Dinner_TableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tables = [
            ['name'=> 'Vierkante tafel', 'seats' => 2], 
            ['name'=> 'Vierkante tafel', 'seats' => 2],
            ['name'=> 'Vierkante tafel', 'seats' => 2],
            ['name'=> 'Vierkante tafel', 'seats' => 2],
            ['name'=> 'Vierkante tafel', 'seats' => 2],
            ['name'=> 'Vierkante tafel', 'seats' => 2],

            ['name'=> 'Rechthoekige tafel', 'seats' => 4],
            ['name'=> 'Rechthoekige tafel', 'seats' => 4],
            ['name'=> 'Rechthoekige tafel', 'seats' => 4],
            ['name'=> 'Rechthoekige tafel', 'seats' => 4],

            ['name'=> 'Ronde tafel', 'seats' => 5],
            ['name'=> 'Ronde tafel', 'seats' => 5],

            ['name'=> 'Rechthoekige tafel welke voor grote groepen aan elkaar kunnen worden geschoven', 'seats' => 6],
            ['name'=> 'Rechthoekige tafel welke voor grote groepen aan elkaar kunnen worden geschoven', 'seats' => 6],
        ];

        foreach ($tables as $table) {
            DinnerTable::create($table);
        }
    }
}
