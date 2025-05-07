<?php

declare(strict_types=1);

namespace App\Actions\Seller;

use App\Models\Profile;
use App\Repositories\Interfaces\ISellerRepository;

class UpdateSeller
{
    public function handle(array $data, int $id): bool
    {
        $profile = Profile::findOrFail($id);
        $profile->fill($data);
        return $profile->save();
    }
}
