<?php

namespace App\Actions\Address;

use App\Repositories\Interfaces\IAddressRepository;

class CreateAddress
{
    public function __construct(private IAddressRepository $repository) {}

    public function handle(array $data)
    {
        $data['user_id'] = auth()->id();

        return $this->repository->create($data);
    }
}
