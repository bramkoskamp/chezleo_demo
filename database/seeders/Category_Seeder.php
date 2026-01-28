<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class Category_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categorys = [
            ['category_name' => 'Lunch', 'start_time' => '00:00:00', 'end_time' => '16:00:00'],
            ['category_name' => 'Dinner', 'start_time' => '16:00:00', 'end_time' => '00:00:00'],
            ['category_name' => 'Dessert', 'start_time' => '16:00:00', 'end_time' => '00:00:00'],
            ['category_name' => 'Drank', 'start_time' => '00:00:00', 'end_time' => '00:00:00'],
        ];

        foreach ($categorys as $category) {
            Category::create($category);
        }
    }
}
