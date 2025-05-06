<?php



namespace App\Models;

enum WithdrawalEnum: string
{
    case Increase = 'Increase';
    case Decrease = 'Decrease';
}
