<?php

use App\Models\Images;
use App\Models\Shop\ShopCategory;
use App\Models\Shop\Zone;
use Carbon\Carbon;
use Illuminate\Support\Str;

if (!function_exists('getViewCustomDate')) {

    function getViewCustomDate($date)
    {
        if ($date) {

            return Carbon::createFromTimestamp(strtotime($date))->format('Y-m-d');
        }
        return '';
    }
}

function getAllImages()
{

    $images = new Images();
    return $images->getimages();
}

function zones()
{

    $data = Zone::where('parent', 0)->get();
    return $data;
}

function categories()
{
    $data = ShopCategory::where('status', 1)->get();
    return $data;
}

function str_random($length = 16)
{
    return Str::random($length);
}


?>
