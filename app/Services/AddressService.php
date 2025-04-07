<?php

namespace App\Services;

use App\Repositories\Interfaces\IAddressRepository;
use App\Services\Interfaces\IAddressService;

class AddressService implements IAddressService
{

    public function __construct(private IAddressRepository $repository)
    {

    }
    public function createAddress(array $data) {
        $data['user_id'] = auth()->id();
        return $this->repository->create($data);
    }
    public function updateAddress(array $data, int $id) {

        $this->repository->update($id, $data);
    }
    public function deleteAddress(int $id) {
        $this->repository->delete($id);
    }
}
