<?php

namespace App\Http\Middleware;

use Closure;

class AccessMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next , $items )
    {
        if (!! $request->user())
        {
            $result = $request->user()->access($items) ;
            if ($result)
            {
                return $next($request);
            }
        }
        return redirect()->route("dashboard.main")->with(['status' => false , 'message' => trans("dashboard.messages.errors.access") ]);
    }
}
