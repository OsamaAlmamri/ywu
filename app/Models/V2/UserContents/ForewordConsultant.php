<?php

namespace App\Models\V2\UserContents;

use App\Models\UserContents\Post;
use App\User;
use Illuminate\Database\Eloquent\Model;

class ForewordConsultant extends Model
{
    //         $table->id();
    //            $table->foreignId('post_id')->constrained('posts');
    //            $table->foreignId('foreword_by')->constrained('users');
    //            $table->foreignId('foreword_to')->constrained(      'users');
    //            $table->longText('solve')->nullable();
    //            $table->enum('status', ['not_solve', 'not_complete', 'solved'])->default('not_solve');

    protected $fillable = ['post_id', 'foreword_by', 'foreword_to', 'solve', 'status'];

    public function foreword_by_user()
    {
        return $this->belongsTo(User::class, 'foreword_by', 'id');
    }

    public function foreword_to_user()
    {
        return $this->belongsTo(User::class, 'foreword_to', 'id');
    }

    public function post()
    {
        return $this->belongsTo(Consultant::class, 'post_id', 'id');
    }

}
