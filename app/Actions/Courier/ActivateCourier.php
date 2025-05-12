<?php

namespace App\Actions\Courier;

use App\Repositories\Interfaces\ICourierRepository;

class ActivateCourier
{
    public function __construct(private readonly ICourierRepository $courierRepository) {}

    public function handle(int $id)
    {
        $courier = $this->courierRepository->getById($id);
        $data = ['active' => $courier->active !== true];

        return $courier->update($data);
    }

}
