<?php

namespace App\Criterions;

use Illuminate\Database\Eloquent\Builder;

interface CriterionInterface
{
    static function getKey(): string;

    static function apply(Builder $qeury, $value = null): Builder;
}
