<?php

namespace App\Models;

use App\Traits\DayTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registro extends Model
{
    use HasFactory, DayTrait;

    protected $fillable = [
        'socket_id',
        'username',
        'email',
        'type',
        'address',
        'url',
        'hostname',
        'host',
        'time',
        'clienttime',
        'timezone',
        'last_time'
    ];
    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';

    private $rules = [
        'createAt' => 'date'
    ];

    function scopeToday(Builder $query)
    {
        $query->whereDate('createdAt', Carbon::now());
    }

    function scopeDesc(Builder $query)
    {
        $query->orderBy('createdAt', 'DESC');
    }
}