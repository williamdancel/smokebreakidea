<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CigarettesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        // Get brand IDs
        $brands = DB::table('cigarette_brands')->pluck('id', 'name');

        $cigarettes = [
            // Marlboro variants
            [
                'brand_id' => $brands['Marlboro'],
                'name' => 'Red',
                'strength' => 'Strong',
                'description' => 'Classic full flavor',
                'tar_content' => 10.0,
                'nicotine_content' => 0.8,
                'is_available' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'brand_id' => $brands['Marlboro'],
                'name' => 'Gold',
                'strength' => 'Medium',
                'description' => 'Original flavor',
                'tar_content' => 8.0,
                'nicotine_content' => 0.6,
                'is_available' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'brand_id' => $brands['Marlboro'],
                'name' => 'Lights',
                'strength' => 'Light',
                'description' => 'Lighter version of the original',
                'tar_content' => 6.0,
                'nicotine_content' => 0.5,
                'is_available' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'brand_id' => $brands['Marlboro'],
                'name' => 'Menthol',
                'strength' => 'Medium',
                'description' => 'Classic menthol flavor',
                'tar_content' => 8.0,
                'nicotine_content' => 0.7,
                'is_available' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'brand_id' => $brands['Marlboro'],
                'name' => 'Southern Cut',
                'strength' => 'Strong',
                'description' => 'Rich, sweet tobacco blend',
                'tar_content' => 11.0,
                'nicotine_content' => 0.9,
                'is_available' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],

            // Camel variants
            [
                'brand_id' => $brands['Camel'],
                'name' => 'Blue',
                'strength' => 'Medium',
                'description' => 'Original blend',
                'tar_content' => 9.0,
                'nicotine_content' => 0.7,
                'is_available' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'brand_id' => $brands['Camel'],
                'name' => 'Filters',
                'strength' => 'Medium',
                'description' => 'Classic camel filters',
                'tar_content' => 10.0,
                'nicotine_content' => 0.8,
                'is_available' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'brand_id' => $brands['Camel'],
                'name' => 'Crush',
                'strength' => 'Medium',
                'description' => 'Menthol capsule cigarettes',
                'tar_content' => 8.0,
                'nicotine_content' => 0.7,
                'is_available' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'brand_id' => $brands['Camel'],
                'name' => 'Turkish Royal',
                'strength' => 'Medium',
                'description' => 'Turkish blend with rich aroma',
                'tar_content' => 9.0,
                'nicotine_content' => 0.8,
                'is_available' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],

            // Winston variants
            [
                'brand_id' => $brands['Winston'],
                'name' => 'Red',
                'strength' => 'Strong',
                'description' => 'Full flavor',
                'tar_content' => 11.0,
                'nicotine_content' => 0.9,
                'is_available' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'brand_id' => $brands['Winston'],
                'name' => 'White',
                'strength' => 'Light',
                'description' => 'Light taste',
                'tar_content' => 6.0,
                'nicotine_content' => 0.5,
                'is_available' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'brand_id' => $brands['Winston'],
                'name' => 'Blue',
                'strength' => 'Ultra Light',
                'description' => 'Ultra light',
                'tar_content' => 4.0,
                'nicotine_content' => 0.4,
                'is_available' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],

            // Newport variants
            [
                'brand_id' => $brands['Newport'],
                'name' => 'Menthol',
                'strength' => 'Strong',
                'description' => 'Classic menthol',
                'tar_content' => 11.0,
                'nicotine_content' => 0.9,
                'is_available' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'brand_id' => $brands['Newport'],
                'name' => 'Menthol Gold',
                'strength' => 'Medium',
                'description' => 'Medium menthol',
                'tar_content' => 8.0,
                'nicotine_content' => 0.7,
                'is_available' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'brand_id' => $brands['Newport'],
                'name' => 'Platinum',
                'strength' => 'Ultra Light',
                'description' => 'Smooth menthol',
                'tar_content' => 4.0,
                'nicotine_content' => 0.4,
                'is_available' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],

            // American Spirit variants
            [
                'brand_id' => $brands['American Spirit'],
                'name' => 'Light Blue',
                'strength' => 'Medium',
                'description' => 'Original full flavor',
                'tar_content' => 8.0,
                'nicotine_content' => 0.7,
                'is_available' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'brand_id' => $brands['American Spirit'],
                'name' => 'Dark Blue',
                'strength' => 'Strong',
                'description' => 'Organic perique blend',
                'tar_content' => 11.0,
                'nicotine_content' => 1.0,
                'is_available' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'brand_id' => $brands['American Spirit'],
                'name' => 'Yellow',
                'strength' => 'Light',
                'description' => 'Mellow medium blend',
                'tar_content' => 6.0,
                'nicotine_content' => 0.5,
                'is_available' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],

            // Other brands
            [
                'brand_id' => $brands['Parliament'],
                'name' => 'White',
                'strength' => 'Light',
                'description' => 'Classic recessed filter',
                'tar_content' => 6.0,
                'nicotine_content' => 0.5,
                'is_available' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'brand_id' => $brands['Lucky Strike'],
                'name' => 'Red',
                'strength' => 'Strong',
                'description' => 'Original unfiltered',
                'tar_content' => 12.0,
                'nicotine_content' => 1.0,
                'is_available' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'brand_id' => $brands['Pall Mall'],
                'name' => 'Red',
                'strength' => 'Medium',
                'description' => 'Classic Pall Mall',
                'tar_content' => 9.0,
                'nicotine_content' => 0.8,
                'is_available' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        DB::table('cigarettes')->insert($cigarettes);
    }
}
