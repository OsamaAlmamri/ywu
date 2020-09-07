<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserTrainingTiltle extends Model
{
    //

    protected $table='user_training_titles';
    protected $fillable=['title_id','user_id'];
}
