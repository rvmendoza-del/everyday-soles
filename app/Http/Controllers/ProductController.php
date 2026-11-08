<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return response()->json(Product::all());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'brand' => 'nullable|string',
            'category' => 'nullable|string',
            'size' => 'nullable|string',
            'color' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|string',
        ]);

        $product = Product::create($data);

        return response()->json($product, 201);
    }

    public function show(string $id)
    {
        return response()->json(Product::findOrFail($id));
    }

    public function update(Request $request, string $id)
    {
        $product = Product::findOrFail($id);

        $data = $request->validate([
            'name' => 'sometimes|required|string',
            'brand' => 'nullable|string',
            'category' => 'nullable|string',
            'size' => 'nullable|string',
            'color' => 'nullable|string',
            'price' => 'sometimes|required|numeric|min:0',
            'quantity' => 'sometimes|required|integer|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|string',
        ]);

        $product->update($data);

        return response()->json($product);
    }

    public function destroy(string $id)
    {
        Product::findOrFail($id)->delete();

        return response()->json([
            'message' => 'Product deleted successfully'
        ]);
    }
}
