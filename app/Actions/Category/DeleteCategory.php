<?php

namespace App\Actions\Category;

use App\Repositories\Interfaces\ICategoryRepository;

class DeleteCategory
{
    public function __construct(private ICategoryRepository $repository)
    {

    }


    public function handle(int $id)
    {
        $category = $this->repository->getById($id);

        /*if (File::exists(public_path('images/categories/' . $category->image))) {
            File::delete(public_path('images/categories/' . $category->image));
        }*/

        return $this->repository->delete($id);
    }

}
