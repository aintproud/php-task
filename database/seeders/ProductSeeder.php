<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        
        DB::table('products')->truncate();
        foreach (range(1, 50) as $index) {
            Product::create([
                'name' => $faker->name,
                'price' => $faker->randomNumber(2),
                'stock' => $faker->randomNumber(3),
                'recommended' => $faker->boolean,
                'delivery_date' => $faker->dateTimeInInterval('now', '+1 year'),
                'description' => $faker->sentence
            ]);
        }
    }
}
