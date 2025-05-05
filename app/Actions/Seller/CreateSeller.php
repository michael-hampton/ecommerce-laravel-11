<?php

namespace App\Actions\Seller;

use App\Models\Profile;
use App\Repositories\Interfaces\ISellerRepository;

class CreateSeller
{
    public function __construct(private ISellerRepository $repository)
    {

    }
    public function handle(array $data): Profile {
        return $this->repository->create($data);
    }
}
