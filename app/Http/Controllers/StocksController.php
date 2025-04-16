<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductHistory;
use Illuminate\Http\Request;

class StocksController extends Controller
{
    public function index()
    {
        return inertia("Dashboard/Stocks/Index", [
            "products" => Product::all()
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|integer|min:1',
            'stock' => 'required|integer|min:1',
        ]);

        $product = Product::create($validated);

        ProductHistory::create([
            'product_id' => $product->id,
            'quantity_change' => $validated['stock'],
            'cost_price' => $request->cost,
        ]);

        return redirect()->back()->with('success', 'Product added!');
    }

    public function edit(Product $product)
    {
        return inertia("Dashboard/Stocks/Edit", [
            'product' => $product
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|integer|min:1',
            'stock' => 'required|integer|min:1',
        ]);

        $originalStock = $product->stock;

        $product->update($validated);

        $stockDiff = $validated['stock'] - $originalStock;

        if ($stockDiff !== 0) {
            ProductHistory::create([
                'product_id' => $product->id,
                'stock_change' => $stockDiff,
            ]);
        }

        return redirect()->route('stocks')->with('success', 'Product updated!');
    }


}
