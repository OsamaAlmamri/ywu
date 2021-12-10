<?php

namespace App\Http\Controllers;


use App\Seller;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use mysql_xdevapi\Exception;
use Spatie\Permission\Models\Role;

class ArtisanCommandsController extends Controller
{
    function clearCache()
    {
        $status = Artisan::call('config:cache');

        return '<h1>Cache cleared</h1>';
    }


    function test()
    {

        $sellers = Seller::all();

        foreach ($sellers as $seller) {
            $user = User::find($seller->admin_id);
            if ($user != null) {
                $user->gov_id = $seller->gov_id;
                $user->district_id = $seller->district_id;
                $user->more_address_info = $seller->more_address_info;

                $user->save();
            }
        }

        $status = Artisan::call('migrate');

        return '<h1>migrate success</h1>';
    }

    function migrate()
    {
        DB::table('migrations')->where('migration', 'like', "%view_%")->delete();

        $status = Artisan::call('migrate');

        return '<h1>migrate success</h1>';
    }

    function role_seed()
    {

        $status = Artisan::call('db:seed --class=RolesAndPermissionsSeeder');

        return '<h1>seed success</h1>';
    }

    function routeCache()
    {
        $status = Artisan::call(' route:cache');

        return '<h1>Route  cleared,cached</h1>';
    }

    function optimizeCache()
    {
        try {
            $status = Artisan::call('optimize');

            return '<h1>optimize execute</h1>';
        } catch (\Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    function clearCompiled()
    {
        try {
            $status = Artisan::call('clear-compiled');

            return '<h1>clear-compiled execute</h1>';
        } catch (\Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    function storageLnk()
    {
        try {
            $status = Artisan::call('storage:link');

            return '<h1>storage linked</h1>';
        } catch (\Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    function telspub()
    {
        try {
            $status = Artisan::call('telescope:publish');

            return '<h1>tels pub</h1>';
        } catch (\Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    function keyGenerate()
    {
        try {
            $status = Artisan::call('key:generate');

            return '<h1>generated  </h1>' . $status;
        } catch (\Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    function envIs()
    {
        try {
            $status = Artisan::call('env');

            return '<h1>env is  </h1>' . $status;
        } catch (\Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
