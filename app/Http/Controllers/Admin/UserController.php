<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Admin\Role;
use App\Model\Admin\User;
use App\Model\Admin\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{
    /**
     * 用户列表
     */
    public function index(Request $request)
    {
//        $query = new User();
//
//        $res = $query->where(function ($query) use ($request) {
//            $request['table_search'] && $query->where('username', 'like', '%' . $request['table_search'] . '%');
//            $request['table_search'] && $query->orWhere('company', 'like', '%' . $request['table_search'] . '%');
////            $request['table_search'] && $query->orWhere('email', 'like', '%' . $request['table_search'] . '%');
//            $request['table_search'] && $query->orWhere('mobile', 'like', '%' . $request['table_search'] . '%');
//        })->paginate(10);

//        $pageList = [
//            'total' => $res->total(),//总条数
//            'lastPage' => $res->lastPage(), //最后一页页码
//            'perPage' => $res->perPage(), //每页条数
//            'currentPage' => $res->currentPage()//当前页
//        ];
        $userList = User::orderBy('id', 'DESC')->get();

        return view(
            'admin.user.index',
            [
                'title' => '用户列表',
                'userList' => $userList,
            ]
        );
    }

    /**
     * 用户添加页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add()
    {
        return view('admin.user.add');
    }

    /**
     * 用户添加方法
     */
    public function create()
    {
        $data = request()->except('_token');
        if ($data['password'] != $data['pwd']) {
            return ['status' => 0, 'message' => '两次密码输入请保持一致'];
        }

        //保存用户信息
        $user_obj = new User();
        $user_obj->username = $data['username'];
        $user_obj->password = md5($data['password']);
        $user_obj->company = $data['company'];
        $user_obj->email = $data['email'];
        $user_obj->mobile = $data['mobile'];
        $user_obj->address = $data['address'];
        $res = $user_obj->save();

        if ($res) {
            $data = ['status' => 1, 'message' => '用户添加成功'];
        } else {
            $data = ['status' => 0, 'message' => '用户添加失败'];
        }

        return $data;
    }

    /**
     * 用户删除方法
     */
    public function delete()
    {
        //获取id
        $id = request()->get('id');

        //查询用户是否存在
        $user = User::find($id);

        if ($user == null) {
            return ['status' => 0, 'success' => '未找到此用户或已被删除'];
        }

        //执行软删除 修改状态90
        $res = User::where('id', $id)->update(['status' => '90']);

        //执行成功
        if ($res == 1) {
            $data = ['status' => 1, 'message' => '用户已删除'];
        } else {
            $data = ['status' => 0, 'message' => '删除未成功'];
        }
        //执行失败
        return $data;

    }

    /**
     * 用户修改页面
     */
    public function edit()
    {
        $id = request()->get('id');

        $user = User::find($id);

        return view('admin.user.edit', ['user' => $user]);
    }

    /**
     * 用户修改方法
     */
    public function update()
    {
        $data = request()->except('_token', 's');

        $userModel = new User();

        $user = $userModel->find($data['id']);

        //如果传输密码与库内密码不同则说明密码进行过修改
        if ($data['password'] != $user['password']) {
            $data['password'] = md5($data['password']);
        }

        $res = User::where('id', $data['id'])->update($data);

        if ($res) {
            $data = ['status' => 1, 'message' => '用户修改成功'];
        } else {
            $data = ['status' => 0, 'message' => '用户修改失败'];
        }

        return $data;
    }

    public function distributePage()
    {
        //获取查询的用户id
        $id = request()->get('id');

        //获取用户数据
        $userDate = User::find($id);

        //获取所有的角色
        $roleDate = Role::get();

        //便利出用户拥有的角色
        $distributeDate = [];
        if (!empty($userDate->role)) {
            foreach ($userDate->role as $v) {
               $distributeDate[] = $v->id;
            }
        }

        return view('admin.user.distribute', [
            'userDate' => $userDate,
            'roleDate' => $roleDate,
            'distributeDate' => $distributeDate,

        ]);

    }

    /**
     * 分配角色
     * @return array
     */
    public function distribute()
    {
        $formData = request()->except('_token','s');

        //删除旧的赋予的角色
        $res = DB::table('user_role')->where('uid', $formData['userId'])->delete();
//        dd($formData);
        if (!empty($formData['roleIds'])) {
            foreach ($formData['roleIds'] as $v) {
                DB::table('user_role')->insert([
                    'uid' => $formData['userId'],
                    'rid' => $v
                ]);
            }
        }

        return ['status' => 1, 'message' => '角色分配成功'];

    }

}
