<?php

namespace App\Repositories;

use App\Models\Address;
use App\Models\Brand;
use App\Repositories\Interfaces\IAddressRepository;

class AddressRepository extends BaseRepository implements IAddressRepository
{
    public function __construct(Address $address) {
        parent::__construct($address);
    }
}
