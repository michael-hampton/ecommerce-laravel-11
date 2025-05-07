<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\Interfaces\IAddressRepository;

class DeleteAddress
{
    public function __construct(private readonly IAddressRepository $addressRepository) {}

    public function handle(int $id): void
    {
        $this->addressRepository->delete($id);
    }
}
