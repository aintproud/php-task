<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function all(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'price_from' => ['numeric'],
            'price_to' => ['numeric', 'gte:price_from'],
            "stock" => ['number'],
            'recommended' => ['boolean'],
            "delivery_date" => ['date'],
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        $products = Product::query()
            ->when($request->filled('price_from'), function ($query) use ($request) {
                $query->where('price', '>=', $request->price_from);
            })
            ->when($request->filled('price_to'), function ($query) use ($request) {
                $query->where('price', '<=', $request->price_to);
            })
            ->when($request->filled('stock'), function ($query) use ($request) {
                $query->where('stock', $request->stock);
            })
            ->when($request->filled('recommended'), function ($query) use ($request) {
                $query->where('recommended', $request->recommended);
            })
            ->when($request->filled('delivery_date'), function ($query) use ($request) {
                $query->whereDate('delivery_date', $request->delivery_date);
            })
            ->paginate(10);

        return response()->json($products);
    }

    public function one($id)
    {
        if (!is_numeric($id)) {
            return response()->json([
                'errors'=> ['id must be numeric']
            ], 422);  
        }
        return response()->json(Product::with('reviews')->findOrFail($id));
    }

    public function addReview(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'rating' => ['required', 'numeric', 'min:1', 'max:5'],
            'comment'=> ['required', "string"]
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }
        $product = Product::findOrFail($id);
        $review = Review::create([
            'product_id' => $product->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);
        return response()->json($review);
    }
}