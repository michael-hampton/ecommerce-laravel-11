<?php

namespace App\Actions\Courier;

use App\Repositories\Interfaces\ICourierRepository;

class UpdateCourier
{
public function __construct(private readonly ICourierRepository $courierRepository) {}

    public function handle(array $data, int $id)
    {
        return $this->courierRepository->update($id, $data);
    }
}
