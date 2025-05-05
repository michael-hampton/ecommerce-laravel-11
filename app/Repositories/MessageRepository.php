<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Post;
use App\Repositories\Interfaces\IMessageRepository;

class MessageRepository extends BaseRepository implements IMessageRepository
{
    public function __construct(Post $post)
    {
        parent::__construct($post);
    }
}
