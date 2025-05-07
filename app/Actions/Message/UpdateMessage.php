<?php

declare(strict_types=1);

namespace App\Actions\Message;

use App\Repositories\Interfaces\IMessageRepository;

class UpdateMessage
{
    public function __construct(private readonly IMessageRepository $messageRepository) {}

    public function handle(array $data, int $id)
    {
        return $this->messageRepository->update($id, $data);
    }
}
