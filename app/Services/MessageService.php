<?php

namespace App\Services;

use App\Models\Comment;
use App\Repositories\Interfaces\IMessageRepository;
use App\Services\Interfaces\IMessageService;

class MessageService implements IMessageService
{

    public function __construct(private IMessageRepository $repository)
    {

    }
    public function createMessage(array $data) {
        return $this->repository->create($data);
    }
    public function updateMessage(array $data, int $id) {

        return $this->repository->update($id, $data);
    }
    public function deleteMessage(int $id) {
        return $this->repository->delete($id);
    }

    public function createComment(array $data) {
        return Comment::create($data);
    }
}
