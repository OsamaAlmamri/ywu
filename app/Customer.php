<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    //
    public $timestamps = false;
    protected $fillable = [
        'user_id',  'gov_id', 'district_id', 'more_address_info'
    ];
}
