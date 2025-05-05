<?php

namespace App\Actions\Message;

use App\Helper;
use App\Models\Comment;
use App\Models\OrderItem;
use App\Repositories\Interfaces\IMessageRepository;

class CreateComment
{

    public function __construct(private IMessageRepository $repository)
    {

    }

   
    /**
     * @param array $data
     * @return mixed
     */
    public function handle(array $data)
    {
        if (!empty($data['images'])) {
            $counter = 0;
            $galleryArr = [];
            foreach ($data['images'] as $file) {
                $gextension = $file->getClientOriginalExtension();
                $check = in_array($gextension, ['png', 'jpg', 'jpeg', 'gif']);
                if ($check) {
                    $gfilename = time() . "-" . $counter . "." . $gextension;
                    $file->storeAs('messages', $gfilename, 'public');
                    Helper::generateThumbnailImage($file, $gfilename, 'messages');
                    array_push($galleryArr, $gfilename);
                    $counter++;
                }
            }
            $galleryImages = implode(',', $galleryArr);
        }

        return Comment::create(array_merge($data, ['images' => $galleryImages ?? null]));
    }
}
