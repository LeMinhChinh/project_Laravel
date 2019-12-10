<?php

namespace App\Http\Middleware;

use Closure;

class checkAge
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $params = null)
    {
        /*
        // before middleware
        // $params : biến nhận giá trị truyền vào từ middleware
        // Xử lí logic thông qua tham số
        // dd($params);
        $myAge = $request->age;
        if($myAge < 18 && $params !== 'admin'){
            return redirect()->route('film-2');
        }
        // thực thi tiếp request routing
        return $next($request);
        */

        // after middleware
        $respone = $next($request);
        $myAge = $request->age;
        if($myAge < 18 && $params !== 'admin'){
            return redirect()->route('film-2');
        }
        return $respone;
    }
}
