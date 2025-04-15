<?php

namespace App\Services\Interfaces;

interface IUserService
{
    public function createUser(array $data);
    public function updateUser(array $data, int $id);
    public function deleteUser(int $id);
}
