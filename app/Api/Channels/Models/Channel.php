<?php

namespace GetCandy\Api\Channels\Models;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    protected $hashids = 'channel';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'default'
    ];
}
