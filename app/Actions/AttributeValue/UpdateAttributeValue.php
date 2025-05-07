<?php

declare(strict_types=1);

namespace App\Actions\AttributeValue;

use App\Repositories\Interfaces\IAttributeValueRepository;

class UpdateAttributeValue
{
    public function __construct(private readonly IAttributeValueRepository $attributeValueRepository) {}

    public function handle(array $data, int $id)
    {
        return $this->attributeValueRepository->update($id, $data);
    }
}
