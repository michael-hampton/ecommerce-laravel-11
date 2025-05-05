<?php

declare(strict_types=1);

namespace App\Actions\Attribute;

use App\Repositories\Interfaces\IAttributeRepository;
use Attribute;

class CreateAttribute
{
    public function __construct(private IAttributeRepository $repository) {}

    public function handle(array $data): Attribute
    {
        return $this->repository->create($data);
    }
}
