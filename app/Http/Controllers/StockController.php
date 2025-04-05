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
    /**
     * @OA\Get(
     *     path="/stock/metrics",
     *     summary="Retorna métricas do estoque",
     *     tags={"Estoque"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Métricas retornadas com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="purchases_total", type="integer", example=150),
     *             @OA\Property(property="categories_total", type="integer", example=12),
     *             @OA\Property(property="provider_total", type="integer", example=5),
     *             @OA\Property(property="employees_total", type="integer", example=8),
     *             @OA\Property(
     *                 property="monthly_purchases",
     *                 type="object",
     *                 example={"Nov": 1234.56, "Oct": 980.25, "Sep": 1100.00}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Não autorizado"
     *     )
     * )
     */
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
