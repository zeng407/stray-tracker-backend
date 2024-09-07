<?php

namespace App\Helpers;

use App\Models\Post;
use Cache;

class Locker
{
    static function lockForCountPostReplies(Post $post)
    {
        $lock = "lock:count_post_replies:{$post->id}";
        Cache::lock($lock)->block(5, function () use ($post) {
            $post->loadCount('post_replies');
        });

        return $post->post_replies_count;
    }
}
