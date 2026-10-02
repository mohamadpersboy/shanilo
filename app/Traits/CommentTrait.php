<?php

namespace App\Traits;

use App\Models\Base\Comment;

Trait CommentTrait
{
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}