<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class ShareUser extends Authenticatable
{

    public $timestamps = false;
    protected $fillable = ['destination', 'type', 'user_id'];
}
