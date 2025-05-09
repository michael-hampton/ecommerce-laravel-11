<?php

declare(strict_types=1);

namespace App\Actions\Address;

use App\Models\Address;
use App\Repositories\Interfaces\IAddressRepository;

class CreateAddress
{
    public function __construct(private readonly IAddressRepository $addressRepository) {}

    public function handle(array $data): Address
    {
        $data['user_id'] = auth()->id();

        return $this->addressRepository->create($data);
    }
}
