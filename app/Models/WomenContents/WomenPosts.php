<?php

namespace App\Models\WomenContents;

use App\Like;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WomenPosts extends Model
{
    use SoftDeletes;

    protected $table = 'women_posts';
    protected $guarded = [];

    protected $appends = ['published'];

    public function getPublishedAttribute()
    {
        return Carbon::createFromTimestamp(strtotime($this->attributes['created_at']))->diffForHumans();
    }

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function user_like()
    {
        $user_id= (auth()->guard('api')->user())?auth()->guard('api')->user()->id:0;
        return $this->hasOne(Like::class, 'liked_id', 'id')
            ->where('type', 'women_posts')
            ->where('user_id', $user_id);
    }

    public function category()
    {
        return $this->belongsTo(WomenCategory::class, 'category_id', 'id');
    }
}
