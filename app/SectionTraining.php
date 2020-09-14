<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SectionTraining extends Model
{
    //
    public $timestamps = false;
    protected $fillable = ['department_id', 'training_id'];
}
