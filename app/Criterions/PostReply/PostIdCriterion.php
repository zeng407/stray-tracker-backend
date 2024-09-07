<?php

namespace App\Criterions\PostReply;


use App\Criterions\CriterionInterface;
use Illuminate\Database\Eloquent\Builder;

class PostIdCriterion implements CriterionInterface
{
    static function getKey(): string
    {
        return 'post_id';
    }

    static function apply(Builder $query, $value = null): Builder
    {
        return $query->where('post_id', $value);
    }
}
