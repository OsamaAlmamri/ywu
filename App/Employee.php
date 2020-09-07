<?php

namespace App;

use App\Models\UserContents\Comment;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Employee extends Authenticatable
{

    public $timestamps = false;
    protected $fillable = ['department_id', 'branch_id', 'job_id', 'user_id'];

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
    }

    public function job()
    {
        return $this->belongsTo(Job::class, 'job_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'emp_id', 'id');
    }


}
