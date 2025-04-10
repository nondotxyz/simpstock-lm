<?php

namespace App\Http\Controllers;

use App\Models\Sales;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // 1. Get the sales for today
        $salesToday = Sales::whereDate('created_at', Carbon::today())->sum('total');

        // 2. Get the sales for the current year
        $sales = Sales::whereYear('created_at', Carbon::now()->year)->get();

        $revenueData = [];
        $expenseData = [];
        $months = [];

        // Collect data for each sale
        foreach ($sales as $sale) {
            $month = Carbon::parse($sale->created_at)->format('F'); // Get month name (e.g., January, February)

            // Store months dynamically
            if (!in_array($month, $months)) {
                $months[] = $month;
            }

            // Calculate revenue (sum of sale totals)
            $revenueData[$month] = ($revenueData[$month] ?? 0) + $sale->total;

            // Calculate expenses (sum of cost prices in sales details)
            $saleDetails = $sale->details;
            foreach ($saleDetails as $detail) {
                $expenseData[$month] = ($expenseData[$month] ?? 0) + ($detail->cost_price * $detail->quantity);
            }
        }

        // Sort months array to ensure the months are in order
        sort($months);

        // Prepare data for the chart
        $revenues = [];
        $expenses = [];

        foreach ($months as $month) {
            $revenues[] = $revenueData[$month] ?? 0;
            $expenses[] = $expenseData[$month] ?? 0;
        }

        return inertia("Dashboard/Index", [
            'salesToday' => $salesToday, // Total sales today
            'revenue' => array_sum($revenues), // Total revenue (sum of all months)
            'expenses' => array_sum($expenses), // Total expenses (sum of all months)
            'chartData' => [
                'months' => $months, // Dynamic months based on the sales data
                'revenue' => $revenues,
                'expenses' => $expenses
            ]
        ]);
    }
}
