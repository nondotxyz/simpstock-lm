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
        $products = Product::all();
        $salesByProduct = [];
        foreach ($products as $product) {
            $totalSold = $product->salesDetails->sum('quantity');
            $salesByProduct[] = [
                'product' => $product->name,
                'total_sold' => $totalSold,
            ];

        }

        $sales = Sales::whereYear('created_at', Carbon::now()->year)->get();
        $revenueData = [];
        $expenseData = [];
        $months = [];

        foreach ($sales as $sale) {
            $month = Carbon::parse($sale->created_at)->format('F');
            $revenueData[$month] = ($revenueData[$month] ?? 0) + $sale->total;

            $saleDetails = $sale->details;
            foreach ($saleDetails as $detail) {
                $expenseData[$month] = ($expenseData[$month] ?? 0) + ($detail->cost_price * $detail->quantity);
            }

            if (!in_array($month, $months)) {
                $months[] = $month;
            }
        }

        sort($months);

        $revenues = [];
        $expenses = [];
        foreach ($months as $month) {
            $revenues[] = $revenueData[$month] ?? 0;
            $expenses[] = $expenseData[$month] ?? 0;
        }

        $salesBySalesperson = Sales::selectRaw('sales_by, sum(total) as total_sales')
            ->groupBy('sales_by')
            ->get();
        $salespersonData = [];
        foreach ($salesBySalesperson as $sale) {
            $salespersonData[] = [
                'salesperson' => $sale->sales_by,
                'total_sales' => $sale->total_sales,
            ];

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