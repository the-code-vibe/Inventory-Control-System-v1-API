<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Purchase;
use App\Models\Category;
use App\Models\Provider;
use App\Models\User;

class StockController extends Controller
{
    public function metrics(Request $request)
    {
        $purchasesTotal = Purchase::count();
        $categoriesTotal = Category::count();
        $providerTotal = Provider::count();
        $employeesTotal = User::where('role', 'stockkeeper')->count();

        $monthlyPurchases = collect(range(0, 5))
            ->mapWithKeys(function ($i) {
                $date = Carbon::now()->subMonths($i);
                $month = $date->format('M');

                $total = Purchase::whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->sum('price');

                return [$month => round($total, 2)];
            })
            ->reverse();

        return response()->json([
            'purchases_total' => $purchasesTotal,
            'categories_total' => $categoriesTotal,
            'provider_total' => $providerTotal,
            'employees_total' => $employeesTotal,
            'monthly_purchases' => $monthlyPurchases,
        ]);
    }
}