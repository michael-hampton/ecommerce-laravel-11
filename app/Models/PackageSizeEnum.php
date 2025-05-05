<?php

declare(strict_types=1);

namespace App\Models;

enum PackageSizeEnum: string
{
    case Large = 'Large';
    case Small = 'Small';
    case Medium = 'Medium';
}
