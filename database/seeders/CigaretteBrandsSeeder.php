<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CigaretteBrandsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        $brands = [
            [
                'name' => 'Marlboro',
                'manufacturer' => 'Philip Morris International',
                'description' => 'One of the world\'s best-selling cigarette brands',
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Camel',
                'manufacturer' => 'R.J. Reynolds Tobacco Company',
                'description' => 'American classic cigarette brand',
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Winston',
                'manufacturer' => 'ITG Brands',
                'description' => 'American cigarette brand known for "The Real Taste"',
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Parliament',
                'manufacturer' => 'Philip Morris International',
                'description' => 'Known for its recessed filter',
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Lucky Strike',
                'manufacturer' => 'British American Tobacco',
                'description' => 'American brand with iconic target logo',
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Newport',
                'manufacturer' => 'Lorillard (now Reynolds American)',
                'description' => 'Popular menthol cigarette brand in the US',
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'American Spirit',
                'manufacturer' => 'Santa Fe Natural Tobacco Company',
                'description' => 'Known for natural and additive-free tobacco',
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Pall Mall',
                'manufacturer' => 'British American Tobacco',
                'description' => 'British cigarette brand with global presence',
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Kent',
                'manufacturer' => 'British American Tobacco',
                'description' => 'Known for its micronite filter',
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Benson & Hedges',
                'manufacturer' => 'Philip Morris International',
                'description' => 'Premium British cigarette brand',
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        DB::table('cigarette_brands')->insert($brands);
    }
}
