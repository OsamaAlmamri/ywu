<?php

use App\Models\Images;
use Carbon\Carbon;
use Illuminate\Support\Str;

if(!function_exists('getViewCustomDate')) {

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

function str_random($length = 16)
{
    return Str::random($length);
}


?>
