<?php

namespace App\Services;

use App\Repositories\Interfaces\ISellerRepository;
use App\Services\Interfaces\ISellerService;

class SellerService implements ISellerService
{
    public function __construct(private ISellerRepository $repository)
    {

    }
    public function createSeller(array $data) {
        return $this->repository->create($data);
    }

    public function updateSeller(array $data, int $id) {
        return $this->repository->update($id, $data);
    }

    public function deleteSeller(int $id) {
        return $this->repository->delete($id);
    }
}
