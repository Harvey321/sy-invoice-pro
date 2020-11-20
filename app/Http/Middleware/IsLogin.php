<?php

namespace App\Http\Middleware;

use Closure;

class IsLogin
{

    public function handle($request, Closure $next)
    {
        if (session()->get('user')){
            return $next($request);
        }else{
            return redirect('admin/login')->with('errors','请先登录');
        }
    }
}
