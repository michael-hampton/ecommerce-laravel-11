<?php

declare(strict_types=1);

namespace App\Models;

enum WithdrawalEnum: string
{
    case Increase = 'Increase';
    case Decrease = 'Decrease';
}
