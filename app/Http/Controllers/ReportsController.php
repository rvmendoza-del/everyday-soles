<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ReportsController extends Controller
{
    public function index()
    {
        // GET ALL PRODUCTS
        $products = Product::all();

        // TOTAL PRODUCTS
        $totalProducts = $products->count();

        // TOTAL STOCK UNITS
        $totalStock = $products->sum(function ($product) {
            return (int) ($product->quantity ?? 0);
        });

        // LOW STOCK PRODUCTS
        $lowStockProducts = $products->filter(function ($product) {
            return (int) ($product->quantity ?? 0) <= 5;
        });

        // TOTAL INVENTORY VALUE
        $inventoryValue = $products->sum(function ($product) {
            return (float) ($product->price ?? 0)
                * (int) ($product->quantity ?? 0);
        });

        // PRODUCTS BY BRAND
        // Normalize brand names to avoid duplicates
        // Example: nike, Nike, NIKE = Nike
        $brandSummary = $products
            ->groupBy(function ($product) {
                $brand = strtolower(trim((string) ($product->brand ?? '')));

                return $brand === ''
                    ? 'Unknown'
                    : ucwords($brand);
            })
            ->map(function ($items) {
                return $items->count();
            })
            ->sortKeys();

        // STOCK BY CATEGORY
        // Normalize category names
        $categorySummary = $products
            ->groupBy(function ($product) {
                $category = strtolower(trim(
                    (string) ($product->category ?? '')
                ));

                return $category === ''
                    ? 'Uncategorized'
                    : ucwords($category);
            })
            ->map(function ($items) {
                return $items->sum(function ($product) {
                    return (int) ($product->quantity ?? 0);
                });
            })
            ->sortKeys();

        // VERIFY CATEGORY STOCK TOTAL
        $categoryStockTotal = $categorySummary->sum();

        // DISPLAY REPORTS PAGE
        return view('reports.index', compact(
            'products',
            'totalProducts',
            'totalStock',
            'lowStockProducts',
            'inventoryValue',
            'brandSummary',
            'categorySummary',
            'categoryStockTotal'
        ));
    }
}
