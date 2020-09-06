<?php

namespace App\Models\UserContents;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';
    protected $guarded = [];
    protected $hidden = ['created_at', 'updated_at'];

    public function posts()
    {
        return $this->hasMany(Post::class, 'category_id', 'id');
    }
}
