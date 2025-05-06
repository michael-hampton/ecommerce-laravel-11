<?php



namespace App\Actions\Seller;

use App\Repositories\Interfaces\ISellerRepository;

class DeleteSeller
{
    public function __construct(private ISellerRepository $repository) {}

    public function handle(int $id): bool
    {
        return $this->repository->delete($id);
    }
}
