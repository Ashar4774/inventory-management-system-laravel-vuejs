<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Vendor;
use Illuminate\Support\Facades\DB;

class VendorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('vendors')->truncate();
        Vendor::insert([
            [
                'name' => 'Alpha Supplies',
                'address' => '123 Main Street, Cityville',
                'phone_no' => '123-456-7890',
                'description' => 'Leading provider of office supplies.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Beta Traders',
                'address' => '456 Commerce Ave, Townburg',
                'phone_no' => '987-654-3210',
                'description' => 'Wholesale trader for electronics and gadgets.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Gamma Goods',
                'address' => '789 Industrial Rd, Factorytown',
                'phone_no' => '555-666-7777',
                'description' => 'Industrial parts and goods supplier.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
