<?php

namespace App\Services;

use App\Repositories\Interfaces\IAddressRepository;
use App\Services\Interfaces\IAddressService;

class DeleteAddress
{
    public function __construct(private IAddressRepository $repository) {
    }

    public function handle(int $id) {
        $this->repository->delete($id);
    }
}
