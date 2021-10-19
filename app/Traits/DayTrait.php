<?php

namespace App\Traits;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

trait DayTrait
{
    function scopeDay(Builder $query, Carbon $date)
    {
        return $query->whereDate('createdAt', $date);
    }
}