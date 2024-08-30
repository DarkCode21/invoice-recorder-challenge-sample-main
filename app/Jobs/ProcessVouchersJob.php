<?php

namespace App\Jobs;

use App\Events\Vouchers\VouchersCreated;
use App\Models\User;
use App\Services\VoucherService;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessVouchersJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $xmlContents;
    protected $user;


    /**
     * Create a new job instance.
     *
     * @param array $xmlContents
     * @param User $user
     */
    public function __construct(array $xmlContents, User $user)
    {
        $this->xmlContents = $xmlContents;
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(VoucherService $voucherService)
    {
        $successfulVouchers = [];
        $failedVouchers = [];

        foreach ($this->xmlContents as $xmlContent) {
            try {
                $voucher = $voucherService->storeVoucherFromXmlContent($xmlContent, $this->user);
                $successfulVouchers[] = $voucher;
            } catch (Exception $e) {
                Log::error('Error al procesar el comprobante: ' . $e->getMessage());
                $failedVouchers[] = [
                    'xml_content' => $xmlContent,
                    'reason' => $e->getMessage(),
                ];
            }
        }

        // Despachar evento para notificar por correo
        VouchersCreated::dispatch($successfulVouchers, $failedVouchers, $this->user);
    }
}