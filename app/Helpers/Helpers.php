<?php

use App\Models\Images;
use App\Models\Shop\ProductsOption;
use App\Models\Shop\ShopCategory;
use App\Models\Shop\Zone;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Spatie\Permission\Models\Role;

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

function formatDateToTimeLine($date)
{
//       return Carbon::parse($date)->diffForHumans();
    return array(
        'month' => Carbon::parse($date)->monthName,
        'day' => Carbon::parse($date)->day,
        'all' => Carbon::parse($date)->day . '/' . Carbon::parse($date)->shortMonthName . '/' . Carbon::parse($date)->year,
    );
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

function getAllRole()
{
    if (auth()->user()->getRoleNames()->first() === 'Developer')
        $roles = Role::all()
            ->where('name', '<>', 'Seller');
    else
        $roles = Role::all()
            ->where('name', '<>', 'Seller')
            ->where('name', '<>', 'Developer');
    $allRoles = [];
    foreach ($roles as $role) {
        if (auth()->user()->getRoleNames()->first() === 'SuperAdmin') {
            if ($role->name != 'Developer')
                $allRoles[$role->id] = $role->name;
        } else {
            if ($role->name != 'SuperAdmin' or $role->name != 'Developer')
                $allRoles[$role->id] = $role->name;
        }
    }
    return $allRoles;
}


function getFirstRole($user_id)
{
    $user = \App\Admin::find($user_id);
    $roles = $user->getRoleNames()->first();
    if (($roles != null))
        $r = Role::all()->where('name', $roles)->first();

    return (($roles == null) ? null : $r->id);
}

function products_option()
{
    $data = ProductsOption::all();
    return $data;
}

function str_random($length = 16)
{
    return Str::random($length);
}


function saveImage($folder, $file, $document = 0)
{
    $folder = '/' . $folder . '/';
    $Image = '';
    $file_name = (str_random(4) . rand());
    if ($file) {
        $Image = $file_name . '.' . $file->getClientOriginalExtension();
        $file->move(public_path($folder), $Image);
        return $folder . $Image;
    }
    return $document == 0 ? $folder . 'default.png' : null;
}


function updateImage($folder, $file, $old_image)
{
    $folder = '/' . $folder . '/';
    if ($file) {
        $file_name = (str_random(4) . rand());
        $Image = $file_name . '.' . $file->getClientOriginalExtension();
        $file->move(public_path($folder), $Image);
        if ($old_image != $folder . 'default.png')
            File::delete(public_path($old_image));
        return $folder . $Image;
    }
    return $old_image;
}

function createImage($img)
{

    $folderPath = "images/";

//        $image_parts = explode(";base64,", $img);
//        $image_type_aux = explode("image/", $image_parts[0]);
    //$image_type ='png';
    $image_base64 = base64_decode($img);

    $f = finfo_open();

    $image_type = finfo_buffer($f, $image_base64, FILEINFO_MIME_TYPE);
    $image_type = (strpos($image_type, 'jpeg') > 0 ? 'jpg' : substr($image_type, -3));

    finfo_close($f);

    $file = $folderPath . uniqid() . '.' . $image_type;


    file_put_contents($file, $image_base64);
    return $file;

}


?>
