<?php

namespace App\Services\Interfaces;

interface IAttributeValueService
{
    public function createAttributeValue(array $data);
    public function updateAttributeValue(array $data, int $id);
    public function deleteAttributeValue(int $id);
}
