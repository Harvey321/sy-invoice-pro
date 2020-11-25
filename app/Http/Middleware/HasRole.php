<?php

namespace App\Http\Middleware;

use App\Model\Admin\User;
use App\Model\Admin\Role;
use App\Model\Admin\Permission;
use Closure;
use Illuminate\Support\Facades\Route;

class HasRole
{
    /**
     * 权限中间件
     */
    public function handle($request, Closure $next)
    {
        //获取当前请求的路由 对应控制器方法名  例："App\Http\Controllers\Admin\RoleController@index"
        $route = Route::current()->getActionName();

        //获取用户的权限组
        $user = User::find(session()->get('user')->id);



        //获取当前用户的角色组
        $roles = $user->role;

        //根据角色找 全部有的权限
        $arr = [];//存放权限临时数组
        foreach ($roles as $v) {
            $perm = $v->permission;//每个角色下的权限路由
            foreach ($perm as $perm){
                $arr[] = $perm->per_url;
            }
        }


        $arr = array_unique($arr); //每个角色下的路由可能重复需要去重

        session()->put('permission',$arr);

        if (in_array($route,$arr)){
            return $next($request);
        }else{
            return redirect('/noAccess');
        }

    }
}
