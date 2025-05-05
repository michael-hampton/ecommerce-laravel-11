<?php

declare(strict_types=1);

namespace App\Actions\AttributeValue;

use App\Repositories\Interfaces\IAttributeValueRepository;

class CreateAttributeValue
{
    public function __construct(private IAttributeValueRepository $repository) {}

    public function handle(array $data)
    {
        return $this->repository->create($data);
    }
}
