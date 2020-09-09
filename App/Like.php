<?php

namespace App;

use App\Models\UserContents\Post;
use App\Models\WomenContents\WomenPosts;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    //
    protected $fillable = ['user_id', 'liked_id', 'type'];


    public function post()
    {
        return $this->belongsTo(Post::class, 'liked_id', 'id');
    }

    public function women_post()
    {
        return $this->belongsTo(WomenPosts::class, 'liked_id', 'id');
    }

}
