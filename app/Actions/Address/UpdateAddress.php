<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\Interfaces\IAddressRepository;

class UpdateAddress
{
    public function __construct(private IAddressRepository $addressRepository) {}

    public function handle(array $data, int $id): void
    {

        $this->addressRepository->update($id, $data);
    }
}
