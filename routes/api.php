<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get("products", [ProductController::class,"all"]);
Route::get("products/{id}", [ProductController::class,"one"]);
Route::post('products/{id}/addReview', [ProductController::class, 'addReview']);
