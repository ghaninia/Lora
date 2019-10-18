<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StatusMiddleware
{
    public function handle(Request $request, Closure $next , $guard )
    {
        if(Auth::guard($guard)->check())
        {
            if(!$request->user()->status)
            {
                Auth::guard($guard)->logout() ;
                return RepMessage(trans('dashboard.messages.errors.status') , false , 'login');
            }
            return $next($request);
        }
    }
}
