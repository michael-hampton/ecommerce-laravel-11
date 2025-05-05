<?php

declare(strict_types=1);

namespace App\Actions\Attribute;

use App\Repositories\Interfaces\IAttributeRepository;

class UpdateAttribute
{
    public function __construct(private IAttributeRepository $repository) {}

    public function handle(array $data, int $id)
    {
        return $this->repository->update($id, $data);
    }
}
