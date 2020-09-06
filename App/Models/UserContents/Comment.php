<?php

namespace App\Models\UserContents;

use App\Employee;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;


class Comment extends Model
{
    protected $table = 'comments';
    protected $guarded = [];

    protected $appends = ['published'];

    public function getPublishedAttribute()
    {
        return Carbon::createFromTimestamp(strtotime($this->attributes['created_at']))->diffForHumans();
    }

    protected $hidden = ['created_at', 'updated_at'];
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'emp_id', 'id');
    }

    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id', 'id');
    }
}
