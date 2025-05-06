<?php

namespace App\Actions\AttributeValue;

use App\Models\AttributeValue;
use App\Repositories\Interfaces\IAttributeValueRepository;

class CreateAttributeValue
{
    public function __construct(private IAttributeValueRepository $repository) {}

    public function handle(array $data): AttributeValue
    {
        return $this->repository->create($data);
    }
}
