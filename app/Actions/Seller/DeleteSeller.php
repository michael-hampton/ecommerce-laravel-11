<?php

declare(strict_types=1);

namespace App\Actions\Seller;

use App\Repositories\Interfaces\ISellerRepository;

class DeleteSeller
{
    public function __construct(private readonly ISellerRepository $sellerRepository) {}

    public function handle(int $id): bool
    {
        return $this->sellerRepository->delete($id);
    }
}
