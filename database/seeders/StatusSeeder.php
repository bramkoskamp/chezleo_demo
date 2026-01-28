<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Status;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            ['status' => 'pending'],
            ['status' => 'preparing'],
            ['status' => 'ready'],
            ['status' => 'served']
        ];

        foreach ($statuses as $status) {
            Status::create($status);
        }
    }
}
