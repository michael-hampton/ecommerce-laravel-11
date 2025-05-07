<?php

declare(strict_types=1);

namespace App\Actions\Message;

use App\Helper;
use App\Models\Comment;

class CreateComment
{
    /**
     * @return mixed
     */
    public function handle(array $data)
    {
        if (! empty($data['images'])) {
            $counter = 0;
            $galleryArr = [];
            foreach ($data['images'] as $file) {
                $gextension = $file->getClientOriginalExtension();
                $check = in_array($gextension, ['png', 'jpg', 'jpeg', 'gif']);
                if ($check) {
                    $gfilename = time().'-'.$counter.'.'.$gextension;
                    $file->storeAs('messages', $gfilename, 'public');
                    Helper::generateThumbnailImage($file, $gfilename, 'messages');
                    $galleryArr[] = $gfilename;
                    $counter++;
                }
            }

            $galleryImages = implode(',', $galleryArr);
        }

        return Comment::create(array_merge($data, ['images' => $galleryImages ?? null]));
    }
}
