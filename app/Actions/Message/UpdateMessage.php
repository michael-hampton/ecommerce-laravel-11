<?php

declare(strict_types=1);

namespace App\Actions\Message;

use App\Repositories\Interfaces\IMessageRepository;

class UpdateMessage
{
    public function __construct(private IMessageRepository $repository) {}

    public function handle(array $data, int $id)
    {
        return $this->repository->update($id, $data);
    }
}
