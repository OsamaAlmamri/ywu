<?php

namespace App\Models\V2\UserContents;

use anlutro\LaravelSettings\ArrayUtil;
use App\Like;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Consultant extends Model
{
    use SoftDeletes;

    protected $table = 'posts';
    protected $guarded = [];


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
        $user_id = (auth()->guard('api')->user()) ? auth()->guard('api')->user()->id : 0;
        return $this->hasOne(Like::class, 'liked_id', 'id')
            ->where('type', 'posts')
            ->where('user_id', $user_id);
    }

    public function likes()
    {
        return $this->hasMany(Like::class, 'liked_id', 'id')
            ->where('type', 'posts');
    }

    public function scopeOfCategory($query, $cat)
    {
        if ($cat >= 1)
            return $query->whereIn('category_id', $cat);
        else return $query;
    }

    public function scopeOfType($query, $type)
    {
        $user_id = (auth()->guard('api')->user()) ? auth()->guard('api')->user()->id : 0;
        if ($type == "fav")
            return $query->whereIn('id', function ($q) use ($user_id) {
                $q->select('liked_id')
                    ->from(with(new Like())->getTable())
                    ->where('type', 'posts')
                    ->where('user_id', $user_id);
            });
        else if ($type == "my")
            return $query->where('user_id', $user_id);
        else if ($user_id > 0)
            return $query->where(function ($query) use ($user_id) {
                $query->where('user_id', $user_id)
                    ->orWhereNotNull('original_post_id');
            });
        else
            return $query;
    }


}
