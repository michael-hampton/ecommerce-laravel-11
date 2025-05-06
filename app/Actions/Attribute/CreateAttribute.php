<?php

namespace App\Actions\Attribute;

use App\Models\ProductAttribute;
use App\Repositories\Interfaces\IAttributeRepository;
use Attribute;

class CreateAttribute
{
    public function __construct(private IAttributeRepository $repository) {}

    public function handle(array $data): ProductAttribute
    {
        return $this->repository->create($data);
    }
}
