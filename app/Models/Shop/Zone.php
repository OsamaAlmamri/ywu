<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Zone extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name_ar',
        'name_en',
        'parent',
        'longitude',
        'latitude',
        'status',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at'
    ];

    /**
     * Scope a query to only include popular users.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeValidateLocation($query, $latitude, $longitude)
    {
        return $query->where('north_east_lat', '>', $latitude)
            ->where('south_west_lat', '<', $latitude)
            ->where('north_east_lng', '>', $longitude)
            ->where('south_west_lng', '<', $longitude);
    }


    public function childZone()
    {
        return $this->hasMany(Zone::class, 'parent', 'id');

    }


    public function zone()
    {
        return $this->belongsTo(Zone::class, 'parent', 'id');
    }

    public function childZoneDeleted()
    {
        return $this->hasMany(Zone::class, 'parent', 'id');

    }
}
