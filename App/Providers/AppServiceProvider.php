<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        if ($this->app->isLocal()) {
            $this->app->register('Barryvdh\Debugbar\ServiceProvider');
        }
    }


    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
//        ini_set('memory_limit','100M');
//        ini_set('post_max_size','50M');
//        ini_set('upload_max_filesize','50M');
        \Illuminate\Support\Facades\Validator::extend('mp3_ogg_extension', function ($attribute, $value, $parameters, $validator) {
            if (!empty($value->getClientOriginalExtension()) && ($value->getClientOriginalExtension() == 'mp3' || $value->getClientOriginalExtension() == 'wave')) {
                return true;
            } else {
                return false;
            }
        });
    }

}
