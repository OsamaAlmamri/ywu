<?php

namespace App\Models\TrainingContents;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TrainingTitle extends Model
{
    use SoftDeletes;

    protected $table = 'training_titles';
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

    public function training()
    {
        return $this->belongsTo(Training::class, 'training_id', 'id');
    }

    public function contents()
    {
        return $this->hasMany(TitleContent::class, 'title_id', 'id');
    }
}
