<?php

namespace App\Actions\Courier;

use App\Repositories\Interfaces\ICourierRepository;

class DeleteCourier
{
    public function __construct(private readonly ICourierRepository $courierRepository)
    {
    }

    public function handle(int $id)
    {        
        return $this->courierRepository->delete($id);
    }
}
