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
        $this->repository->create($data);
    }

    public function updateSeller(array $data, int $id) {
        $this->repository->update($id, $data);
    }

    public function deleteSeller(int $id) {
        $this->repository->delete($id);
    }
}
