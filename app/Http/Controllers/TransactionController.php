<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductHistory;
use App\Models\Sales;
use App\Models\SalesDetail;
use DB;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        return inertia("Dashboard/Transaction/Index", [
            "products_list" => Product::all(),
        ]);
    }

    public function store(Request $request)
    {

        DB::beginTransaction();

        try {

            $sale = Sales::create([
                'total' => $request->total,
                'sales_by' => 1,
            ]);


            foreach ($request->selectedProducts as $productData) {

                $product = Product::findOrFail($productData['id']);


                if ($product->stock < $productData['quantity']) {

                    DB::rollBack();
                    return response()->json(['message' => 'Not enough stock for product ' . $product->name], 400);
                }

                $latestProductHistory = ProductHistory::where('product_id', $product->id)
                    ->orderBy('created_at', 'desc')
                    ->first();

                $costPrice = $latestProductHistory ? $latestProductHistory->cost_price : $product->price;

                $subtotal = $productData['total'];

                SalesDetail::create([
                    'product_id' => $product->id,
                    'sales_id' => $sale->id,
                    'quantity' => $productData['quantity'],
                    'cost_price' => $costPrice,
                    'sub_total' => $subtotal,
                ]);


                $product->decrement('stock', $productData['quantity']);


                ProductHistory::create([
                    'product_id' => $product->id,
                    'quantity_change' => -$productData['quantity'],
                    'cost_price' => $product->price,
                ]);
            }


            DB::commit();


            return response()->json(['message' => 'Sale recorded successfully'], 200);

        } catch (\Exception $e) {

            DB::rollBack();


            return response()->json(['message' => 'Failed to record sale: ' . $e->getMessage()], 500);
        }
    }

    public function list()
    {
        $sales = Sales::with('details.product')
            ->latest()
            ->get()
            ->map(function ($sale) {
                return [
                    'id' => $sale->id,
                    'customer' => $sale->customer,
                    'date' => $sale->created_at->format('Y-m-d'),
                    'total' => $sale->total,
                    'details' => $sale->details->map(function ($detail) {
                        return [
                            'product' => $detail->product->name,
                            'quantity' => $detail->quantity,
                            'price' => $detail->sub_total,
                        ];
                    }),
                ];
            });

        return inertia('Dashboard/Transaction/List', [
            'sales' => $sales,
        ]);
    }
}
