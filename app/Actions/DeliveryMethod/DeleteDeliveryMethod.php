<?php

namespace App\Actions\DeliveryMethod;

use App\Repositories\DeliveryMethodRepository;

class DeleteDeliveryMethod
{

    public function __construct(private DeliveryMethodRepository $repository)
    {

    }

    public function handle(int $id): bool
    {
        return $this->repository->delete($id);
    }

}
