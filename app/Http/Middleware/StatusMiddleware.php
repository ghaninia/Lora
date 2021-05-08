<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StatusMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if ( optional(Auth::user())->status)
            return $next($request);

        Auth::logout();
        return RepMessage(trans('lora.messages.errors.status'), false, 'login');
}
}
