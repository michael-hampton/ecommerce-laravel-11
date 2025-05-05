<?php

declare(strict_types=1);

namespace App\Actions\Category;

use App\Repositories\Interfaces\ICategoryRepository;

class ActivateCategory
{
    public function __construct(private ICategoryRepository $repository) {}

    public function handle(int $id)
    {
        $category = $this->repository->getById($id);
        $data = ['active' => $category->active === true ? false : true];

        return $category->update($data);
    }
}
