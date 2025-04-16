<?php

namespace App\Services;

use App\Helper;
use App\Repositories\Interfaces\IAttributeRepository;
use App\Services\Interfaces\IAttributeService;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class AttributeService implements IAttributeService
{
    public function __construct(private IAttributeRepository $repository)
    {

    }


    public function createAttribute(array $data) {

        $this->repository->create($data);
    }

    public function updateAttribute(array $data, int $id) {
        $this->repository->update($id, $data);
    }

    public function deleteAttribute(int $id) {
        $this->repository->delete($id);
    }
}
