<?php

namespace App;

use App\Models\TrainingContents\Training;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class EmployeeCategory extends Model
{
    protected $guarded = [];
    protected $appends = ['published'];

    public function getPublishedAttribute()
    {
        return Carbon::createFromTimestamp(strtotime($this->attributes['created_at']))->diffForHumans();
    }

    protected $hidden = [
        'created_at', 'deleted_at'
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function employees()
    {
        return $this->hasMany(Employee::class, 'category_id', 'id');
    }

    public function trainings()
    {
        return $this->belongsToMany(Training::class, Category_Training::class, 'training_id', 'category_id', 'id', 'id');
    }
}
