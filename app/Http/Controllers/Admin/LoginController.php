<?php

namespace App\Http\Controllers\Admin;

use App\Model\Admin\User;
use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class LoginController extends Controller
{
    /**
     * 后台登录页面
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        session()->forget('user');
        if (session()->get('user')) {
            return redirect('/admin/user');
        }
        return view('admin.login');
    }

    /**
     * 登录方法
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function doLogin(Request $request)
    {

        $formDate = request()->except('_token');

        //验证规则
        $rule = [
            'username' => 'required',
            'password' => 'required'
        ];
        //错误信息
        $msg = [
            'username.required' => '用户名必须输入',
            'password.required' => '密码必须输入'
        ];
        //表单验证
        $validator = Validator::make($formDate, $rule, $msg);
        //提取表单错误新
        if ($validator->errors()->messages()) {
            return json_encode(['status' => 'error', 'message' => $validator->errors()->first()]);
        }
        //获取用户信息
        $user = User::where('username', $formDate['username'])->first();

        //验证code
        if (strtolower($formDate['code']) == '') {
            return json_encode(['status' => 'error', 'message' => '请输入验证码!']);
        }
        if (strtolower($formDate['code']) != strtolower(session()->get('code'))) {
            return json_encode(['status' => 'error', 'message' => '验证码错误!']);
        }

        //判断用户是否存在
        if (!$user) {
            return json_encode(['status' => 'error', 'message' => '无此用户!']);
        }
        //判断密码是否正确
        if ($user['password'] != md5($formDate['password'])) {
            return json_encode(['status' => 'error', 'message' => '密码错误!']);
        }
        //判断用户是否可用
        if ($user['status'] != 10) {
            return json_encode(['status' => 'error', 'message' => '该账号暂无登录权限!']);
        }
        //闪存用户信息
        session()->put('user', $user);
        //返回成功信息
        return json_encode(['status' => 'success', 'message' => '登录成功']);
    }

    /**
     * 退出登录
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function loginOut()
    {
        session()->flush();
        return redirect('admin/login');
    }

    /**
     * 验证码
     * @param $tmp
     */
    public function captcha($tmp)
    {
        $phrase = new PhraseBuilder;
        //设置验证码位数
        $code = $phrase->build(4);
        //生成验证码图片Builder对象，配置相应属性
        $builder = new CaptchaBuilder($code, $phrase);
        //设置背景颜色
        $builder->setBackgroundColor(220, 210, 230);
        $builder->setMaxAngle(25);
        $builder->setMaxBehindLines(0);
        $builder->setMaxFrontLines(0);
        //可以设置图片宽高字体
        $builder->build($width = 100, $height = 40, $font = null);
        //获取验证验证码内容
        $phrase = $builder->getPhrase();
        //把内容存入session
        \request()->session()->flash('code', $phrase);
        //生成图片
        header("Cache-Control: no-cache, must-revalidate");
        header("Content-Type:image/jpeg");
        $builder->output();

    }

    /**
     * 没有权限的跳转页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function noAccess()
    {
        return view('admin/noAccess');
    }

}
