<?php

namespace App\Models;

enum NotificationTypeEnum: int
{
    case ADDED_TO_WISHLIST = 1;
    case ITEM_IN_WISHLIST_SOLD = 2;

    case ITEM_IN_WISHLIST_REDUCED = 3;

    case FEEDBACK_RECIEVED = 4;
}
