<?php

namespace App\Models\Shop;

use App\Admin;
use App\User;
use Illuminate\Database\Eloquent\Model;

class QuestionReplay extends Model
{
    //

    protected $fillable = [
        'product_question_id', 'replay_user_id', 'text', 'replay_user_type',
    ];


    function user()
    {
        return $this->belongsTo(User::class, 'replay_user_id', 'id');
    }

    function admin()
    {
        return $this->belongsTo(Admin::class, 'replay_user_id', 'id');
    }

}

