<?php

declare(strict_types=1);

namespace App\Actions\Seller;

use App\Repositories\Interfaces\ISellerRepository;

class UpdateSeller
{
    public function __construct(private ISellerRepository $repository) {}

    public function handle(array $data, int $id)
    {
        return $this->repository->update($id, $data);
    }
}
