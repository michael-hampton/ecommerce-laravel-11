<?php

namespace App\Services;

use App\Repositories\DeliveryMethodRepository;
use App\Repositories\Interfaces\IDeliveryMethodRepository;
use App\Services\Interfaces\IDeliveryMethodService;

class DeliveryMethodService implements IDeliveryMethodService
{

    public function __construct(private DeliveryMethodRepository  $repository)
    {

    }
    public function createDeliveryMethod(array $data) {
        return $this->repository->create($data);
    }
    public function updateDeliveryMethod(array $data, int $id) {
        $this->repository->update($id, $data);
    }
    public function deleteDeliveryMethod(int $id) {
        $this->repository->delete($id);
    }
}
