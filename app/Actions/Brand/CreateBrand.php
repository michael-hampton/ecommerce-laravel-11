<?php

declare(strict_types=1);

namespace App\Actions\Brand;

use App\Helper;
use App\Models\Brand;
use App\Repositories\Interfaces\IBrandRepository;
use Illuminate\Support\Str;

class CreateBrand
{
    public function __construct(private readonly IBrandRepository $brandRepository) {}

    public function handle(array $data): Brand
    {
        $data['slug'] = Str::slug($data['name']);
        $filename = time().'.'.$data['image']->getClientOriginalExtension();
        $data['image']->storeAs('brands', $filename, 'public');

        // Thumbnail
        Helper::generateThumbnailImage($data['image'], $filename, 'brands');
        $data['image'] = $filename;

        return $this->brandRepository->create($data);
    }
}
