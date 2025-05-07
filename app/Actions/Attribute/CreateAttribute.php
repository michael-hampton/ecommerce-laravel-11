<?php

declare(strict_types=1);

namespace App\Actions\Attribute;

use App\Models\ProductAttribute;
use App\Repositories\Interfaces\IAttributeRepository;
use Attribute;

class CreateAttribute
{
    public function __construct(private IAttributeRepository $attributeRepository) {}

    public function handle(array $data): ProductAttribute
    {
        return $this->attributeRepository->create($data);
    }
}
