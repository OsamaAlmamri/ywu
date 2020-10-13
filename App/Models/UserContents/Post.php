<?php

namespace App\Models\UserContents;

use App\Like;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;

    protected $table = 'posts';
    protected $guarded = [];

    protected $appends = ['published','comments_count','likes_count'];

    public function getPublishedAttribute()
    {
        return Carbon::createFromTimestamp(strtotime($this->attributes['created_at']))->diffForHumans();
    }
    function getLikesCountAttribute(){
        return $this->likes()->count();

    }function getCommentsCountAttribute(){
        return $this->comments()->count();
    }

    protected $dates = ['deleted_at'];
    protected $hidden = [
        'created_at', 'updated_at'
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'post_id', 'id');
    }

    public function user_like()
    {
        $user_id= (auth()->guard('api')->user())?auth()->guard('api')->user()->id:0;
        return $this->hasOne(Like::class, 'liked_id', 'id')
            ->where('type', 'posts')
            ->where('user_id', $user_id);
    }
    public function likes()
    {
        return $this->hasMany(Like::class, 'liked_id', 'id')
            ->where('type', 'posts');
    }


}
