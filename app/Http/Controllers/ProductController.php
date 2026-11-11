<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\InventorySnapshot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // DISPLAY PRODUCTS MANAGEMENT PAGE
    public function index()
    {
        $products = Product::all();

        return view('products.index', compact('products'));
    }

    // DASHBOARD JSON DATA
    public function data()
    {
        return response()->json(Product::all());
    }

    // SHOW ADD PRODUCT FORM
    public function create()
    {
        return view('products.create');
    }

    // SAVE NEW PRODUCT
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'nullable|string',
            'category' => 'nullable|string',
            'size' => 'nullable|string',
            'color' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image_file' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        if ($request->hasFile('image_file')) {

            $path = $request->file('image_file')
                ->store('products', 'public');

            $data['image'] = Storage::disk('public')->url($path);
        }

        $product = Product::create($data);

        $this->recordInventorySnapshot();

        return response()->json([
            'message' => 'Product added successfully!',
            'product' => $product
        ], 201);
    }

    // SHOW SINGLE PRODUCT
    public function show(string $id)
    {
        $product = Product::findOrFail($id);

        return response()->json($product);
    }

    // SHOW EDIT FORM
    public function edit(string $id)
    {
        $product = Product::findOrFail($id);

        return view('products.edit', compact('product'));
    }

    // UPDATE PRODUCT
    public function update(Request $request, string $id)
    {
        $product = Product::findOrFail($id);

        $data = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'brand' => 'nullable|string',
            'category' => 'nullable|string',
            'size' => 'nullable|string',
            'color' => 'nullable|string',
            'price' => 'sometimes|required|numeric|min:0',
            'quantity' => 'sometimes|required|integer|min:0',
            'description' => 'nullable|string',
            'image_file' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        if ($request->hasFile('image_file')) {

            $oldImage = $product->image;

            $path = $request->file('image_file')
                ->store('products', 'public');

            $data['image'] = Storage::disk('public')->url($path);

            if ($oldImage && str_contains($oldImage, '/storage/products/')) {

                $oldPath = parse_url($oldImage, PHP_URL_PATH);

                Storage::disk('public')->delete(
                    substr($oldPath, strlen('/storage/'))
                );
            }
        }

        $product->update($data);

        $this->recordInventorySnapshot();

        return redirect()->route('products.index')
            ->with('success', 'Product updated successfully!');
    }

    // DELETE PRODUCT
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);

        $image = $product->image;

        $product->delete();

        if ($image && str_contains($image, '/storage/products/')) {

            $imagePath = parse_url($image, PHP_URL_PATH);

            Storage::disk('public')->delete(
                substr($imagePath, strlen('/storage/'))
            );
        }

        $this->recordInventorySnapshot();

        return response()->json([
            'message' => 'Product deleted successfully!'
        ]);
    }

    // RECORD INVENTORY SNAPSHOT
    private function recordInventorySnapshot()
    {
        $products = Product::all();

        $totalStock = $products->sum(
            fn($product) => (int) ($product->quantity ?? 0)
        );

        $inventoryValue = $products->sum(
            fn($product) =>
                (float) ($product->price ?? 0) *
                (int) ($product->quantity ?? 0)
        );

        InventorySnapshot::create([
            'total_stock' => $totalStock,
            'inventory_value' => $inventoryValue,
            'product_count' => $products->count(),
            'recorded_at' => now(),
        ]);
    }

    // GET INVENTORY TREND DATA
    public function trend()
    {
        // CREATE INITIAL SNAPSHOT IF NONE EXISTS
        if (InventorySnapshot::count() === 0) {
            $this->recordInventorySnapshot();
        }

        // GET LATEST 30 SNAPSHOTS
        $snapshots = InventorySnapshot::orderBy(
            'recorded_at',
            'desc'
        )
        ->limit(30)
        ->get()
        ->sortBy('recorded_at')
        ->values();

        return response()->json($snapshots);
    }
}