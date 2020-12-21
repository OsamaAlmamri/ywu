<?php

namespace App;

use App\Models\TrainingContents\Training;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Category_Training extends Model
{
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

    public function trainings()
    {
        return $this->belongsTo(Training::class, 'training_id', 'id');
    }

    public function emp_categories()
    {
        return $this->belongsTo(EmployeeCategory::class, 'category_id', 'id');
    }
}
