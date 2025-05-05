<?php

namespace App\Actions\Message;


use App\Repositories\Interfaces\IMessageRepository;

class DeleteMessage
{

    public function __construct(private IMessageRepository $repository)
    {

    }

   
    public function handle(int $id)
    {
        return $this->repository->delete($id);
    }
}
