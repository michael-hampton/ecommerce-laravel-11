<?php

namespace App\Actions\Courier;

use App\Models\Courier;
use App\Repositories\Interfaces\ICourierRepository;

class CreateCourier
{
    public function __construct(private readonly ICourierRepository $courierRepository)
    {
    }

    public function handle(array $data): Courier
    {
        return $this->courierRepository->create($data);
    }
}
