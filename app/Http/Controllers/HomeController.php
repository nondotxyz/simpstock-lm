<?php

namespace App\Http\Controllers;

use App\Models\Sales;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $salesToday = Sales::whereDate('created_at', Carbon::today())->sum('total');

        $sales = Sales::whereYear('created_at', Carbon::now()->year)->get();

        $revenueData = [];
        $expenseData = [];
        $months = [];

        foreach ($sales as $sale) {
            $month = Carbon::parse($sale->created_at)->format('F');

            if (!in_array($month, $months)) {
                $months[] = $month;
            }

            $revenueData[$month] = ($revenueData[$month] ?? 0) + $sale->total;


            $saleDetails = $sale->details;
            foreach ($saleDetails as $detail) {
                $expenseData[$month] = ($expenseData[$month] ?? 0) + ($detail->cost_price * $detail->quantity);
            }
        }


        sort($months);


        $revenues = [];
        $expenses = [];

        foreach ($months as $month) {
            $revenues[] = $revenueData[$month] ?? 0;
            $expenses[] = $expenseData[$month] ?? 0;
        }

        return inertia("Dashboard/Index", [
            'salesToday' => $salesToday,
            'revenue' => array_sum($revenues),
            'expenses' => array_sum($expenses),
            'chartData' => [
                'months' => $months,
                'revenue' => $revenues,
                'expenses' => $expenses
            ]
        ]);
    }
}
