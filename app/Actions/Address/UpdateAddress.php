<?php

declare(strict_types=1);

namespace App\Actions\Address;

use App\Repositories\Interfaces\IAddressRepository;

class UpdateAddress
{
    public function __construct(private readonly IAddressRepository $addressRepository) {}

    public function handle(array $data, int $id): bool
    {
        $address = $this->addressRepository->getById($id);
        $address->fill($data);
        return $address->save();
    }
}
