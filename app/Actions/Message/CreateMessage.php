<?php



namespace App\Actions\Message;

use App\Helper;
use App\Models\OrderItem;
use App\Repositories\Interfaces\IMessageRepository;

class CreateMessage
{
    public function __construct(private IMessageRepository $repository) {}

    /**
     * @return mixed
     */
    public function handle(array $data)
    {
        $sellerId = $data['sellerId'] ?? null;

        if (empty($sellerId) && ! empty($data['orderItemId'])) {
            $orderItem = OrderItem::whereId($data['orderItemId'])->first();
            $sellerId = $orderItem->seller_id;
        }

        if (! empty($data['images'])) {
            $counter = 0;
            $gallery_arr = [];
            foreach ($data['images'] as $file) {
                $gextension = $file->getClientOriginalExtension();
                $check = in_array($gextension, ['png', 'jpg', 'jpeg', 'gif']);
                if ($check) {
                    $gfilename = time().'-'.$counter.'.'.$gextension;
                    $file->storeAs('messages', $gfilename, 'public');
                    Helper::generateThumbnailImage($file, $gfilename, 'messages');
                    array_push($gallery_arr, $gfilename);
                    $counter = $counter + 1;
                }

                $counter++;
            }
            $gallery_images = implode(',', $gallery_arr);
        }

        return $this->repository->create([
            'user_id' => auth()->id(),
            'title' => $data['title'],
            'message' => $data['comment'],
            'seller_id' => $sellerId,
            'order_item_id' => $data['orderItemId'] ?? null,
            'images' => $gallery_images ?? null,
        ]);
    }
}
