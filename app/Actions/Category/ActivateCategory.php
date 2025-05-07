<?php

declare(strict_types=1);

namespace App\Actions\Category;

use App\Repositories\Interfaces\ICategoryRepository;

class ActivateCategory
{
    public function __construct(private readonly ICategoryRepository $categoryRepository) {}

    public function handle(int $id)
    {
        $category = $this->categoryRepository->getById($id);
        $data = ['active' => $category->active !== true];

        return $category->update($data);
    }
}
