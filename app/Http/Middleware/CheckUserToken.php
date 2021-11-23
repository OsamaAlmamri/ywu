<?php

namespace App\Http\Middleware;

use App\Traits\JsonTrait;
use Closure;
use Illuminate\Support\Facades\Config;
use Tymon\JWTAuth\Facades\JWTAuth;
class CheckUserToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    use JsonTrait;
    public function handle($request, Closure $next)
    {

     //   return $request;

        $user = null;
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (\Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return $this -> ReturnErorrRespons('E3001','يرجى تسجيل الدخول');
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return $this -> ReturnErorrRespons('E3001','EXPIRED_TOKEN');
            } else {
                return $this -> ReturnErorrRespons('E3001','قم بتسجيل الدخول من فضلك');
            }
        } catch (\Throwable $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return $this -> ReturnErorrRespons('E3001','INVALID_TOKEN');
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return $this -> ReturnErorrRespons('E3001','EXPIRED_TOKEN');
            } else {
                return $this -> ReturnErorrRespons('E3001','TOKEN_NOTFOUND');
            }
        }

        if (!$user)
        $this -> ReturnErorrRespons('E3001',trans('Unauthenticated'));
        return $next($request);
    }
    }

