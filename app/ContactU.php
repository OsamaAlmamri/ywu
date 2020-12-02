<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ContactU extends Model
{
    //
    protected $appends = ['published'];

    public function getPublishedAttribute()
    {
        return Carbon::createFromTimestamp(strtotime($this->attributes['created_at']))->diffForHumans();
    }
    protected $table='contact_us';
    protected $fillable = [
        'name',  'email', 'phone', 'message','gov'
    ];
}
