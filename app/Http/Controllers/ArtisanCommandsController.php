<?php

namespace App\Http\Controllers;

use App\Console\Commands\StockItemSyncData;
use App\Models\General\Developer;
use App\Models\General\DeveloperReAssigns;
use App\Models\General\DevelopersMonthlyEvaluation;
use App\Models\General\DeveloperTarget;
use App\Models\General\Governorate;
use App\Models\General\PosCode;
use App\Models\General\PosDetail;
use App\Models\General\Region;
use App\Models\General\TEST;
use App\Models\General\User;
use App\Models\Requests\ReAssignSim;
use App\Models\Stocks\DwPosSalesSimChange;
use App\Models\Stocks\DwPosStock;
use App\Models\Stocks\DwReceivedContracts;
use App\Models\Stocks\SoldSim;
use App\Models\Stocks\Stock;
use App\Models\Stocks\StockItem;
use Carbon\Carbon;
use Database\Seeders\RolesAndPermissionsSeeder;
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
