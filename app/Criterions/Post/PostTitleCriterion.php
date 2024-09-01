<?php

namespace App\Criterions\Post;


use App\Criterions\CriterionInterface;
use Illuminate\Database\Eloquent\Builder;

class PostTitleCriterion implements CriterionInterface
{
    static function getKey(): string
    {
        return 'title';
    }

    static function apply(Builder $query, $value = null): Builder
    {
        return $query->where('title', 'like', "%$value%");
    }
}
