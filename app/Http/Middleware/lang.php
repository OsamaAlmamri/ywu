<?php

namespace App\Http\Middleware;

use Closure;

class lang
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if(session()->has('lang')){
            app()->setLocale(session('lang','ar'));
        }
        else{
            app()->setLocale('ar');
        }


       // app()->setLocale(lang()) ;

        return $next($request);
    }
}
