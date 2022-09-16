<?php

use App\Admin;
use App\User;
use App\Device;
use App\Models\Images;
use App\Models\Shop\ProductsOption;
use App\Models\Shop\ShopCategory;
use App\Models\Shop\Zone;

use App\Seller;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
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
function getDBCustomDate()
{

    return '%Y-%m-%d %h:%i:%s %p';
}

function notification_type($id, $type)
{
    switch ($type) {
        case 'new_share_user':
            return route('SharedUser', $id);
            break;
        case 'new_seller':
            return route('admin.shop.sellers.index');
            break;
        case 'new_post':
            return route('admin.home');
            break;
        case 'payment':
            return route('admin.shop.payments.index');
            break;
        case 'sub_order':
            return route('admin.shop.orders.show_seller_order', $id);
            break;
        case 'order':
            return route('admin.shop.orders.show_main_order', $id);
            break;
        case 'new_training_user':
            return route('user_trainings');
            break;
        case 'cancel_order':
            return route('admin.shop.orders.show_seller_order', $id);
            break;
        default:
            return '/admin/home';
    }


}

if (!function_exists('getAdminsOrderNotifucation')) {
    function getAdminsOrderNotifucation($event_status)
    {
        $admins = Admin::all()->where('type', 'admin');
        return $admins;
    }
}
function DatediffForHumans($date)
{
    return Carbon::createFromTimestamp(strtotime($date))->diffForHumans();
}

function getNotifiableUsers($user = 0, $admins = [])
{
    $tokens = [];
    $devices = DB::table('devices')
        ->where(function ($query) use ($user) {
            $query->where('user_type', 'like', 'user')
                ->where('user_id', $user);
        })
        ->orWhere(function ($query) use ($admins) {
            $query->where('user_type', 'like', 'admin')
                ->whereIn('user_id', $admins);
        })->get();
    foreach ($devices as $device)
        $tokens[] = $device->device_token;
    return $tokens;
}


function setFirBaseToken($data)
{
    $devices = Device::where('device_token', $data['device_token'])->delete();
//
    $device = Device::all()
        ->where('user_type', 'like', $data['user_type'])
        ->where('device_id', 'like', $data['device_id'])
        ->where('device_type', 'like', $data['device_type'])
        ->first();
    if ($device == null)
        Device::create($data);
    else
        $device->update($data);
    return 1;
}

function get_devic_mac()
{
//    return substr(exec('getmac'), 0, 17);
    return 1;
}

function set_users_decices($request)
{
    if (isset($request->device_type) and $request->device_type == 'web') {
        $device_id = get_devic_mac();
    } else {
        $device_id = $request->device_type;
    }
    $data = array(
        'user_id' => \auth()->id(),
        'user_type' => 'user',
        'device_id' => $device_id,
        'device_token' => $request->device_token,
        'device_type' => $request->device_type,
    );
    setFirBaseToken($data);
}

function getSpesificStatus($status = 0)
{

    $s = [
        'new' => trans('status.order_new'),
        'cancel_by_seller' => trans('status.order_cancel_by_seller'),
        'cancel_by_user' => trans('status.order_cancel_by_user'),
        'in_progress' => trans('status.order_in_progress'),
        'shipping' => trans('status.order_shipping'),
        'delivery' => trans('status.order_delivery'),
    ];
    if ($status == 'all')
        return $s;
    if ($status != 0)
        return $s[$status];
    else {
        return $s;
    }
}


function getSellerOrderStatus($status = 0)
{

    $s = array(
        'new' => trans('status.order_new'),
        'in_progress' => trans('status.order_in_progress'),
        'shipping' => trans('status.order_shipping'),
        'delivery' => trans('status.order_delivery'),
    );
    if ($status == 'all')
        return $s;
    if ($status != 0)
        return $s[$status];
    else {
        return $s;
    }
}


function getCities()
{
    $allCities = Zone::all()->where('parent', 0);
    $cities = [];
    foreach ($allCities as $city) {
        $cities[$city->id] = $city->name_ar;
    }

    return $cities;
}

function paymentStatus($status = 'all')
{
    $s = array(
        'all' => "الكل",
        '0' => trans('status.payment_0'),
        '1' => trans('status.payment_1'),

    );
    if ($status == 'all')
        return $s;
    if ($status != 0)
        return $s[$status];
    else {
        return $s;
    }
    return $s[$status];
}

function paymentStatus2($status = 'all')
{
    $s = array(
        '0' => trans('status.payment_0'),
        '1' => trans('status.payment_1'),

    );

    return $s;

}

function CouponUsedStatus($status = 'all')
{
    $s = array(
        'all' => "الكل",
        '0' => trans('status.coupons_used_0'),
        '1' => trans('status.coupons_used_1'),

    );
    if ($status == 'all')
        return $s;
    if ($status != 0)
        return $s[$status];
    else {
        return $s;
    }
    return $s[$status];
}

function CouponEndStatus($status = 'all')
{
    $s = array(
        'all' => "الكل",
        '0' => trans('status.coupons_end_1'),
        '1' => trans('status.coupons_end_0'),

    );
    if ($status == 'all')
        return $s;
    if ($status != 0)
        return $s[$status];
    else {
        return $s;
    }
    return $s[$status];
}

function confirm_paymentStatus($status = 'all')
{

    $s = array(
        'all' => "الكل",
        '0' => trans('status.confirm_payment_0'),
        '1' => trans('status.confirm_payment_1'),
        '2' => trans('status.confirm_payment_2'),

    );
    if ($status == 'all')
        return $s;
    if ($status != 0)
        return $s[$status];
    else {
        return $s;
    }
    return $s[$status];
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

function sellers()
{
    $data = Seller::whereIn('admin_id', function ($query) {
        $query->select('id')
            ->from(with(new Admin())->getTable())
            ->where('users.deleted_at', null);
    })->get();
    return $data;
}

function getZones($governorate_id = 0)
{
    if ($governorate_id == 0) {
        $governorate = Zone::where('parent', '=', '0')->first();
        if ($governorate != null)
            $governorate_id = $governorate->id;
        else
            return [];
    }
    $allZones = Zone::all()->where('parent', '=', $governorate_id);

    $zones = [];
    foreach ($allZones as $zone) {
        $zones[($zone->id)] = $zone->name_ar;
    }
    return $zones;

}


function getGovernorates()
{
    $allGovernorate = Zone::all()->where('parent', '=', 0);
    $governorates = [];
    foreach ($allGovernorate as $governorate) {
        $governorates[$governorate->id] = $governorate->name_ar;
    }

    return $governorates;
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
