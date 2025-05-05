<?php

declare(strict_types=1);

namespace App\Models;

enum WithdrawalTypeEnum: string
{
    case Withdrawal = 'withdrawal';
    case OrderSpent = 'order_spent';
    case OrderReceived = 'order_received';

    case BumpProduct = 'product_bumped';
}
