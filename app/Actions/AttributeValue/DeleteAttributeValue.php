<?php

declare(strict_types=1);

namespace App\Actions\AttributeValue;

use App\Repositories\Interfaces\IAttributeValueRepository;

class DeleteAttributeValue
{
    public function __construct(private readonly IAttributeValueRepository $attributeValueRepository) {}

    public function handle(int $id)
    {
        return $this->attributeValueRepository->delete($id);
    }
}
