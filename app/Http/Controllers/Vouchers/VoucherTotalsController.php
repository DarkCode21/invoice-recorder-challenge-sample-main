<?php

namespace App\Http\Controllers\Vouchers;

use App\Models\Voucher;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;

class VoucherTotalsController
{
    /**
     * Obtener los totales acumulados en soles y dólares por usuario.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getTotals(Request $request): JsonResponse
    {
        try {
            $user = auth()->user(); 

            $totalPEN = Voucher::where('user_id', $user->id)
                ->where('currency_code', 'PEN')
                ->sum('total_amount');

            $totalUSD = Voucher::where('user_id', $user->id)
                ->where('currency_code', 'USD')
                ->sum('total_amount');

            return response()->json([
                'total_pen' => $totalPEN,
                'total_usd' => $totalUSD,
            ]);
            
        } catch (Exception $e) {
            Log::error("Error al calcular los totales: " . $e->getMessage());
            return response()->json([
                'error' => 'Error al calcular los totales.'
            ], 500);
        }
    }
}
