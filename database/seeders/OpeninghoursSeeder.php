<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\OpeningHour;

class OpeninghoursSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $openingHours = [
            ['day_of_week' => '0', 'open' => '12:00:00', 'close' => '23:00:00'],
            ['day_of_week' => '1', 'open' => '09:00:00', 'close' => '09:00:00'],
            ['day_of_week' => '2', 'open' => '09:00:00', 'close' => '09:00:00'],
            ['day_of_week' => '3', 'open' => '17:00:00', 'close' => '22:00:00'],
            ['day_of_week' => '4', 'open' => '12:00:00', 'close' => '22:00:00'],
            ['day_of_week' => '5', 'open' => '12:00:00', 'close' => '23:00:00'],
            ['day_of_week' => '6', 'open' => '12:00:00', 'close' => '23:00:00'],
        ];

        foreach ($openingHours as $day) {
            OpeningHour::create($day);
        }
    }
}
