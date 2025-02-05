<?php

namespace App\Models\Shop;

use App\Models\Shop\ProductsOption;
use App\Models\Shop\ProductsOptionsValue;
use App\Models\Shop\Zone;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Seller2 extends Model
{
    //
    protected $table='sellers';
    public $timestamps = false;
    protected $fillable = [
        'admin_id', 'images', 'sale_name', 'ssn_image', 'gov_id', 'district_id', 'more_address_info'
    ];


//    protected $appends = ['district', 'gov'];

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

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id', 'id');
    }


}
