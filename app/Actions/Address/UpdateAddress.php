<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\Interfaces\IAddressRepository;

class UpdateAddress
{
    public function __construct(private IAddressRepository $repository) {}

    public function handle(array $data, int $id)
    {

        $this->repository->update($id, $data);
    }
}
