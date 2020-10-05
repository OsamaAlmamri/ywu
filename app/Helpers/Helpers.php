<?php

use Carbon\Carbon;

if(!function_exists('getViewCustomDate')) {

    function getViewCustomDate($date)
    {
        if ($date) {

            return Carbon::createFromTimestamp(strtotime($date))->format('Y-m-d');
        }
        return '';
    }
}


?>
