<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\WithdrawalRequested;

class WithdrawalRequestedListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(WithdrawalRequested $withdrawalRequested): void
    {
        //
    }
}
