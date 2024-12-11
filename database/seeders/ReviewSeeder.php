<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        DB::table('reviews')->truncate();
        foreach (range(1, 100) as $index) {
            $product = Product::has('reviews', '<', 2)
            ->inRandomOrder()
            ->limit(1)
            ->select('id')
            ->first();

            Review::create([
                'rating' => $faker->randomNumber(1),
                'comment' => $faker->sentence,
                'product_id' => $product->id
            ]);
        }
    }
}
