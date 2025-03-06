<?php

namespace App\Domains\Dashboard\Models;

use Illuminate\Database\Eloquent\Model;

class StoreHour extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'day',
        'open_time',
        'close_time',
        'lunch_start',
        'lunch_end',
    ];
}
