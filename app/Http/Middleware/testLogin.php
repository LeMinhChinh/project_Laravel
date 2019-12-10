<?php

namespace App\Http\Middleware;

use Closure;

class testLogin
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
        $username = $request->user;
        if(!$this->checkUserLogin($username)){
            return redirect()->route('group.index');
        }
        return $next($request);
    }

    private function checkUserLogin($user)
    {
        if($user == 'admin'){
            return true;
        }
        return false;
    }
}
