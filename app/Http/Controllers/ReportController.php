<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sales;
use App\Models\SalessDetail;
use App\Models\Product;
use Carbon\Carbon;

class ReportController extends Controller
{

    public function index()
    {
        // 1. Sales by Product
        $products = Product::all();
        $salesByProduct = [];
        foreach ($products as $product) {
            $totalSold = $product->salesDetails->sum('quantity');
            $salesByProduct[] = [
                'product' => $product->name,
                'total_sold' => $totalSold,
            ];

            // This assumes salesDetails relation on Product model
        }

        // 2. Revenue and Expenses by Month
        $sales = Sales::whereYear('created_at', Carbon::now()->year)->get();
        $revenueData = [];
        $expenseData = [];
        $months = [];

        foreach ($sales as $sale) {
            $month = Carbon::parse($sale->created_at)->format('F');
            $revenueData[$month] = ($revenueData[$month] ?? 0) + $sale->total;

            // Calculate Expenses
            $saleDetails = $sale->details;
            foreach ($saleDetails as $detail) {
                $expenseData[$month] = ($expenseData[$month] ?? 0) + ($detail->cost_price * $detail->quantity);
            }

            if (!in_array($month, $months)) {
                $months[] = $month;
            }
        }

        // Sorting months in chronological order
        sort($months);

        $revenues = [];
        $expenses = [];
        foreach ($months as $month) {
            $revenues[] = $revenueData[$month] ?? 0;
            $expenses[] = $expenseData[$month] ?? 0;
        }

        // 3. Sales by Salesperson (Assuming the `sales_by` field is a foreign key to the Cashier model)
        $salesBySalesperson = Sales::selectRaw('sales_by, sum(total) as total_sales')
            ->groupBy('sales_by')
            ->get();
        $salespersonData = [];
        foreach ($salesBySalesperson as $sale) {
            $salespersonData[] = [
                'salesperson' => $sale->sales_by,
                'total_sales' => $sale->total_sales,
            ];

            // Assuming you can relate salesperson data directly via sales_by
        }

        return inertia('Dashboard/Report/Index', [
            'salesByProduct' => $salesByProduct,
            'salesToday' => Sales::whereDate('created_at', Carbon::today())->sum('total'),
            'revenue' => array_sum($revenues),
            'expenses' => array_sum($expenses),
            'chartData' => [
                'months' => $months,
                'revenue' => $revenues,
                'expenses' => $expenses,
            ],
            'salespersonData' => $salespersonData,
        ]);
    }

}