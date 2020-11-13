<?php

namespace App;

use App\Models\Shop\ProductsOption;
use App\Models\Shop\ProductsOptionsValue;
use App\Models\Shop\Zone;
use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{
    //
    public $timestamps = false;
    protected $fillable = [
        'admin_id', 'sale_name', 'ssn_image', 'gov_id', 'district_id', 'more_address_info'
    ];


    protected $appends = ['district', 'gov'];

    function getDistrictAttribute()
    {
        $im = $this->district()->get()->first();
        return ($im != null) ? $im->name_ar : null;
    }

    function getGovAttribute()
    {
        $im = $this->gov()->get()->first();
        return ($im != null) ? $im->name_ar : null;
    }


    public function gov()
    {
        return $this->belongsTo(Zone::class, 'gov_id', 'id');
    }

    public function district()
    {
        return $this->belongsTo(Zone::class, 'district_id', 'id');
    }

}
