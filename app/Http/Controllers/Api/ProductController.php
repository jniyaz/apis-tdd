<?php

namespace App\Http\Controllers\Api;

use App\Product;
use App\Http\Resources\Product as ProductResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function store(Request $request) {

        $product = Product::create([
            'name' => $request->name,
            'slug' => str_slug($request->slug),
            'price' => $request->price
        ]);

        return response()->json(new ProductResource($product), 201);
    }
}
