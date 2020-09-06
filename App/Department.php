<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    //
    protected $appends = ['published'];

    public function getPublishedAttribute()
    {
        return Carbon::createFromTimestamp(strtotime($this->attributes['created_at']))->diffForHumans();
    }
    //


    public function employees()
    {
        return $this->hasMany(Employee::class,'department_id','id');
    }

}
