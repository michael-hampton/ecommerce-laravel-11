<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Profile;
use App\Repositories\Interfaces\ISellerRepository;

class SellerRepository extends BaseRepository implements ISellerRepository
{
    public function __construct(Profile $profile)
    {
        parent::__construct($profile);
    }
}
