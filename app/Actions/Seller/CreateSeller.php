<?php

declare(strict_types=1);

namespace App\Actions\Seller;

use App\Models\Profile;
use App\Repositories\Interfaces\ISellerRepository;

class CreateSeller
{
    public function __construct(private ISellerRepository $sellerRepository) {}

    public function handle(array $data): Profile
    {
        return $this->sellerRepository->create($data);
    }
}
