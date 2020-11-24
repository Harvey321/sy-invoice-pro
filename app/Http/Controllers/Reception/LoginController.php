<?php

namespace App\Http\Controllers\Reception;

use App\Http\Controllers\Controller;
use App\Model\Admin\Customer;
use App\Model\Product;
use Illuminate\Support\Facades\Validator;


class LoginController extends Controller
{
    /**
     * 登录页面
     */
    public function index()
    {
        $user = session()->get('customer');

        if ($user){
            return redirect('/customer/product');
        }

        return view('reception.login');
    }

    /**
     * 登录方法
     */
    public function doLogin()
    {
        $formDate = request()->except('_token','s');

        var_dump($formDate)
        die;

        if (empty($formDate['username'])) {
            return ['status'=>'0','message'=>'请输入用户名'];
        }
        if (empty($formDate['password'])) {
            return ['status'=>'0','message'=>'请输入密码'];
        }
        if (empty($formDate['code'])) {
            return ['status'=>'0','message'=>'请输入验证码'];
        }

        if (strtolower($formDate['code']) != strtolower(session()->get('code'))) {
            return ['status'=>'0','message'=>'验证码错误'];
        }

        $user = Customer::where('username', $formDate['username'])->first();

        if (!$user) {
            return ['status'=>'0','message'=>'无此用户'];
        }
        if ($user['password'] != md5($formDate['password'])) {
            return ['status'=>'0','message'=>'密码错误'];
        }

        session()->put('customer', $user);

        return ['status'=>'1','message'=>'登录成功'];//接待首页
    }


    /**
     * 退出登录
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function loginOut()
    {
        session()->flush();
        return redirect('/login');
    }



}