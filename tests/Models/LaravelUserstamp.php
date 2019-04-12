<?php

namespace Sqits\UserStamps\Tests\Models;

use Illuminate\Database\Eloquent\Model;
use Sqits\UserStamps\Traits\UserStamps;
use Illuminate\Database\Eloquent\SoftDeletes;

class LaravelUserstamp extends Model
{
    use UserStamps, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];
}
