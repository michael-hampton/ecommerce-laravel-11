<?php

namespace App\Services\Interfaces;

interface IAttributeService
{
    public function createAttribute(array $data);
    public function updateAttribute(array $data, int $id);
    public function deleteAttribute(int $id);
}
