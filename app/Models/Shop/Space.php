<?php

namespace App\Models\Shop;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Space extends Model
{
    //

    protected $appends = ['zone', 'published'];


    public function getPublishedAttribute()
    {
        return Carbon::createFromTimestamp(strtotime($this->attributes['created_at']))->diffForHumans();
    }

    function getZoneAttribute()
    {
        $im = $this->zone();
        return ($im != null) ? $this->zone()->name_ar : null;
    }

    public function zone()
    {
        return $this->belongsTo(Zone::class, 'zone_id', 'id')
            ->first();
    }

    protected $fillable = ['zone_id', 'name', 'description', 'status'];
}
