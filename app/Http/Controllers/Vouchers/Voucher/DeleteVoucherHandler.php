<?php

namespace App\Http\Controllers\Vouchers\Voucher;

use App\Models\Voucher;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DeleteVoucherHandler
{
    public function __invoke($id): JsonResponse
    {
        $user = auth()->user();
        $voucher = Voucher::where('id', $id)->where('user_id', $user->id)->first(); 

        if (!$voucher) {
            return response()->json([
                'message' => 'Comprobante no encontrado o no pertenece al usuario.',
            ], 404);
        }

        $voucher->delete();

        return response()->json([
            'message' => 'Comprobante eliminado con éxito.',
        ], 200);
    }
}