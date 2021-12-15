<?php

namespace App\Models\Shop;

use App\User;
use Illuminate\Database\Eloquent\Model;

class QuestionReplay extends Model
{
    //

    protected $fillable = [
        'product_question_id',  'replay_user_id', 'text', 'replay_user_type',
    ];
    protected $appends=['user_name'];


    function user()
    {
        return $this->belongsTo(User::class, 'replay_user_id', 'id');
    }

    function admin()
    {
        return $this->belongsTo(User::class, 'replay_user_id', 'id');
    }

    function getUserNameAttribute()
    {
        if ($this->attributes['replay_user_type'] == "admin")

            $im = $this->admin()->get()->first();
        else
            $im = $this->user()->get()->first();
        return ($im != null) ? $im->name : null;
    }

}

