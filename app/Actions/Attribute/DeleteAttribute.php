<?php

declare(strict_types=1);

namespace App\Actions\Attribute;

use App\Repositories\Interfaces\IAttributeRepository;

class DeleteAttribute
{
    public function __construct(private readonly IAttributeRepository $attributeRepository) {}

    public function handle(int $id)
    {
        return $this->attributeRepository->delete($id);
    }
}
