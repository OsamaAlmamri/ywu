<?php

namespace App\Models\WomenContents;


use Illuminate\Database\Eloquent\Model;

class WomenCategory extends Model
{
    protected $table = 'women_categories';
    protected $guarded = [];
    protected $hidden = ['created_at', 'updated_at'];

    public function posts()
    {
        return $this->hasMany(WomenPosts::class, 'category_id', 'id');
    }
}
