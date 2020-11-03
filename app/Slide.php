<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Slide extends Model
{
    //

    protected $fillable = ['sort', 'description', 'status', 'action_type', 'action_id', 'image'];
}
