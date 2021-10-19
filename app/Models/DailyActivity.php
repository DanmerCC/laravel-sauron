<?php

namespace App\Models;

use App\Traits\DayTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'hostname',
        'username',
        'online_time',
        'errors'
    ];

    function scopeDay(Builder $query, Carbon $date)
    {
        return $query->whereDate('created_at', $date);
    }
}