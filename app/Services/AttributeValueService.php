<?php

namespace App\Services;

use App\Helper;
use App\Repositories\Interfaces\IAttributeValueRepository;
use App\Services\Interfaces\IAttributeValueService;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class AttributeValueService implements IAttributeValueService
{
    public function __construct(private IAttributeValueRepository $repository)
    {

    }


    public function createAttributeValue(array $data) {
        return $this->repository->create($data);
    }

    public function updateAttributeValue(array $data, int $id) {
        return $this->repository->update($id, $data);
    }

    public function deleteAttributeValue(int $id) {
        return $this->repository->delete($id);
    }
}
