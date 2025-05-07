<?php

declare(strict_types=1);

namespace App\Actions\DeliveryMethod;

use App\Repositories\DeliveryMethodRepository;

class DeleteDeliveryMethod
{
    public function __construct(private readonly DeliveryMethodRepository $deliveryMethodRepository) {}

    public function handle(int $id): bool
    {
        return $this->deliveryMethodRepository->delete($id);
    }
}
