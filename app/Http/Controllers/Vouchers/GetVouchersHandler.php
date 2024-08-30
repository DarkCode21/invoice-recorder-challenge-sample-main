<?php

namespace App\Http\Controllers\Vouchers;

use App\Http\Requests\Vouchers\GetVouchersRequest;
use App\Http\Resources\Vouchers\VoucherResource;
use App\Models\Voucher;
use Illuminate\Http\Response;
use App\Services\VoucherService;

class GetVouchersHandler
{
    public function __construct(private readonly VoucherService $voucherService)
    {
    }

    public function __invoke(GetVouchersRequest $request): Response
    {
        $user = auth()->user();

        // Array de filtros con sus respectivos campos
        $filters = [
            'document_serie' => 'document_serie',
            'document_number' => 'document_number',
            'date_from' => ['created_at', '>='],
            'date_to' => ['created_at', '<='],
        ];

        // Construcción de la consulta con filtros
        $query = Voucher::where('user_id', $user->id);

        foreach ($filters as $requestKey => $dbColumn) {
            if ($request->filled($requestKey)) {
                $filterValue = $request->input($requestKey);
                is_array($dbColumn)
                    ? $query->whereDate($dbColumn[0], $dbColumn[1], $filterValue)
                    : $query->where($dbColumn, $filterValue);
            }
        }

        $vouchers = $query->paginate(
            perPage: $request->query('paginate'),
            page: $request->query('page') 
        );

        if ($vouchers->isEmpty()) {
            return response([
                'message' => 'No se encontraron comprobantes con los filtros aplicados.',
            ], 404);
        }

        return response([
            'data' => VoucherResource::collection($vouchers),
        ], 200);
    }
}
