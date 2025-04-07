<?php

namespace App\Services\Interfaces;

interface IAddressService
{
    public function createAddress(array $data);
    public function updateAddress(array $data, int $id);
    public function deleteAddress(int $id);
}
