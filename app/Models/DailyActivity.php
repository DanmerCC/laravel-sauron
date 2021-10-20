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

    function scopeSearchUser(Builder $query, string $text)
    {
        $query->where('username', 'like', $text . '%');
        $query->orWhere('username', 'like', '%' . $text . '%');
        $query->orWhere('username', 'like', '%' . $text);
        $query->orWhere('username', '=', $text);
        return $query;
    }

    function scopeSearchHostname(Builder $query, string $text)
    {
        $query->where('hostname', 'like', $text . '%');
        $query->orWhere('hostname', 'like', '%' . $text . '%');
        $query->orWhere('hostname', 'like', '%' . $text);
        $query->orWhere('hostname', '=', $text);
    }
}