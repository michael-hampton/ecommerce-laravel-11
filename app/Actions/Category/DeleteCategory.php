<?php

declare(strict_types=1);

namespace App\Actions\Category;

use App\Repositories\Interfaces\ICategoryRepository;

class DeleteCategory
{
    public function __construct(private readonly ICategoryRepository $categoryRepository) {}

    public function handle(int $id)
    {
        $this->categoryRepository->getById($id);

        /*if (File::exists(public_path('images/categories/' . $category->image))) {
            File::delete(public_path('images/categories/' . $category->image));
        }*/

        return $this->categoryRepository->delete($id);
    }
}
