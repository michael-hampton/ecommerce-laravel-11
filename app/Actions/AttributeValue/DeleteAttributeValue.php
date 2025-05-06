<?php

namespace App\Actions\AttributeValue;

use App\Repositories\Interfaces\IAttributeValueRepository;

class DeleteAttributeValue
{
    public function __construct(private IAttributeValueRepository $repository) {}

    public function handle(int $id)
    {
        return $this->repository->delete($id);
    }
}
