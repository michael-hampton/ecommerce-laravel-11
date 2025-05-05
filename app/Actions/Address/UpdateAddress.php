<?php

namespace App\Services;

use App\Repositories\Interfaces\IAddressRepository;
use App\Services\Interfaces\IAddressService;

class UpdateAddress
{
    public function __construct(private IAddressRepository $repository) {
    }

    public function handle(array $data, int $id) {

        $this->repository->update($id, $data);
    }
}
