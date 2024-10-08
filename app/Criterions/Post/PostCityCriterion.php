<?php

namespace App\Criterions\Post;


use App\Criterions\CriterionInterface;
use Illuminate\Database\Eloquent\Builder;

class PostCityCriterion implements CriterionInterface
{
    static function getKey(): string
    {
        return 'city';
    }

    static function apply(Builder $query, $value = null): Builder
    {
        if(is_array($value)) {
            return $query->whereIn('city', $value);
        }else if(is_string($value)) {
            return $query->where('city', $value);
        }
    }
}
