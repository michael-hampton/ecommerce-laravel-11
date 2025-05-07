<?php

declare(strict_types=1);

namespace App\Actions\Attribute;

use App\Repositories\Interfaces\IAttributeRepository;

class UpdateAttribute
{
    public function __construct(private readonly IAttributeRepository $attributeRepository) {}

    public function handle(array $data, int $id)
    {
        return $this->attributeRepository->update($id, $data);
    }
}
