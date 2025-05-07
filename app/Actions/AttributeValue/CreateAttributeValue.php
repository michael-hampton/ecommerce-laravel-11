<?php

declare(strict_types=1);

namespace App\Actions\AttributeValue;

use App\Models\AttributeValue;
use App\Repositories\Interfaces\IAttributeValueRepository;

class CreateAttributeValue
{
    public function __construct(private readonly IAttributeValueRepository $attributeValueRepository) {}

    public function handle(array $data): AttributeValue
    {
        return $this->attributeValueRepository->create($data);
    }
}
