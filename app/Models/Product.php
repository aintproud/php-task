<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'price', 'stock', 'recommended', 'delivery_date', 'description'];

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }


    public function addReview($rating, $comment)
    {
        Review::create([
            'product_id' => $this->id,
            'rating' => $rating,
            'comment' => $comment
        ]);
        return 1;
    }
}