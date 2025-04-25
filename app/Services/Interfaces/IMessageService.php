<?php

namespace App\Services\Interfaces;

interface IMessageService
{
    public function createMessage(array $data);
    public function updateMessage(array $data, int $id);
    public function deleteMessage(int $id);
    public function createComment(array $data);
}
