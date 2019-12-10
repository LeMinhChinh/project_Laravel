<?php

namespace App\Http\Middleware;

use Closure;

class checkNumber
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
        $myNumber = $request->number;
        if($myNumber %2 != 0){
            return redirect()->route('number-1');
        }
        // thực thi tiếp request routing
        return $next($request);
    }
}
