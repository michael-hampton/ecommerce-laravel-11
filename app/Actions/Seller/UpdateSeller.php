<?php

declare(strict_types=1);

namespace App\Actions\Seller;

use App\Helper;
use App\Models\Profile;
use Log;

class UpdateSeller
{
    public function handle(array $data, int $id): Profile
    {
        $profile = Profile::findOrFail($id);
        $profile->fill($data);

        if (!empty($data['image'])) {
            $filename = time() . '.' . $data['image']->getClientOriginalExtension();
            $data['image']->storeAs('sellers', $filename, 'public');

            // Thumbnail
            //Helper::generateThumbnailImage($data['image'], $filename, 'sellers');
            $profile->profile_picture = $filename;
        }

        $profile->save();

        return $profile->fresh();
    }
}
