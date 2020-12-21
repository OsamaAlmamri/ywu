<?php

namespace App\Models\TrainingContents;

use Illuminate\Database\Eloquent\Model;

class SubjectCategory extends Model
{
    protected $table = 'subject_categories';
    protected $guarded = [];
    protected $hidden = ['created_at', 'updated_at'];

    public function subjects()
    {
        return $this->hasMany(Subject::class, 'category_id', 'id');
    }

    public function trainings()
    {
        return $this->hasMany(Training::class, 'category_id', 'id');
    }
}
