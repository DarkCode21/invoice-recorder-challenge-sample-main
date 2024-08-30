<?php

namespace App\Events\Vouchers;


use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class VouchersCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @param array $successfulVouchers
     * @param array $failedVouchers
     * @param User $user
     */
    public function __construct(
        public readonly array $successfulVouchers,
        public readonly array $failedVouchers,
        public readonly User $user
    ) {
    }
}