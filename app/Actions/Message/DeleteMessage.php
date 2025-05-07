<?php

declare(strict_types=1);

namespace App\Actions\Message;

use App\Repositories\Interfaces\IMessageRepository;

class DeleteMessage
{
    public function __construct(private IMessageRepository $messageRepository) {}

    public function handle(int $id)
    {
        return $this->messageRepository->delete($id);
    }
}
