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
            return (float) ($product->price ?? 0) *
                   (int) ($product->quantity ?? 0);
        });

        // PRODUCTS BY BRAND
        $brandSummary = $products
            ->groupBy(function ($product) {
                return $product->brand ?: 'Unknown';
            })
            ->map(function ($items) {
                return $items->count();
            });

        // STOCK BY CATEGORY
        $categorySummary = $products
            ->groupBy(function ($product) {
                return $product->category ?: 'Uncategorized';
            })
            ->map(function ($items) {
                return $items->sum(function ($product) {
                    return (int) ($product->quantity ?? 0);
                });
            });

        // DISPLAY REPORTS PAGE
        return view('reports.index', compact(
            'products',
            'totalProducts',
            'totalStock',
            'lowStockProducts',
            'inventoryValue',
            'brandSummary',
            'categorySummary'
        ));
    }
}
