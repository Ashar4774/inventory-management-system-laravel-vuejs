<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->truncate();
        Category::insert([
            [
                'title' => 'Electronics',
                'description' => 'Devices and gadgets',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Furniture',
                'description' => 'Household furnishings',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Laptop',
                'description' => 'Used and new laptops',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Laptop PC',
                'description' => 'Used and new laptop PCs',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
