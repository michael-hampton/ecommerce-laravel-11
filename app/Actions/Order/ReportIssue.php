<?php

namespace App\Actions\Order;

use App\Actions\Message\CreateMessage;
use App\Events\IssueReported;
use App\Models\OrderItem;

class ReportIssue
{
    public function __construct(private CreateMessage $createMessage)
    {
    }

    public function handle(array $data, int $orderItemId)
    {
        $reason = trim($data['reason']);
        $orderItem = OrderItem::whereId($orderItemId);
        $title = $reason === 'returnRefund' ? 'Refund Requested from buyer. Items should be returned' : 'Refund Requested from buyer. They do not wish to return the items';

        $orderItemUpdateData = [
            'status' => $reason === 'returnRefund' || $reason === 'refundNoReturn' ? 'refund_requested' : 'issue_reported'
        ];

        $orderItem->update($orderItemUpdateData);

        $orderItem = $orderItem->first();

        $result = $this->createMessage->handle([
            'title' => $title,
            'images' => $data['images'],
            'comment' => $data['message'],
            'sellerId' => $orderItem->seller_id,
            'orderItemId' => $orderItem->id,
            'user_id' => auth()->user()->id,
        ]);

        event(new IssueReported(auth()->user()->email, [
            'item' => $orderItem,
            'currency' => config('shop.currency'),
            'message' => $data['message'],
            'resolution' => $title,
            'customer' => auth()->user()->name,
        ]));

        return $result;
    }
}
