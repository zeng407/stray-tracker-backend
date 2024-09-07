<?php

namespace App\Criterions\Post;


use App\Criterions\CriterionInterface;
use Illuminate\Database\Eloquent\Builder;

class PostDistrictCriterion implements CriterionInterface
{
    static function getKey(): string
    {
        return 'district';
    }

    static function apply(Builder $query, $value = null): Builder
    {
        if(is_array($value)) {
            return $query->whereIn('district', $value);
        }else if(is_string($value)) {
            return $query->where('district', $value);
        }
    }
}
