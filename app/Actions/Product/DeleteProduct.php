<?php



namespace App\Actions\Product;

use App\Repositories\Interfaces\IProductRepository;

class DeleteProduct
{
    public function __construct(private IProductRepository $repository) {}

    public function handle(int $id)
    {
        $product = $this->repository->getById($id);

        /*if (File::exists(public_path('images/products/' . $product->image))) {
            File::delete(public_path('images/products/' . $product->image));
        }*/

        return $this->repository->delete($id);
    }
}
