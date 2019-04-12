<?php

namespace Sqits\UserStamps\Tests\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Sqits\UserStamps\Traits\UserStamps;

class LaravelUserstamp extends Model
{
    use UserStamps, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];
}
