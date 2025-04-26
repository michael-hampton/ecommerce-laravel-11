<?php

namespace App\Repositories;

use App\Models\Address;
use App\Models\DeliveryMethod;
use App\Repositories\Interfaces\ICourierRepository;
use App\Repositories\Interfaces\IDeliveryMethodRepository;

class DeliveryMethodRepository extends BaseRepository implements IDeliveryMethodRepository
{
    public function __construct(DeliveryMethod $deliveryMethod) {
        parent::__construct($deliveryMethod);
    }
}
