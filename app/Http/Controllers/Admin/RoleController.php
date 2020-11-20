<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Admin\Permission;
use App\Model\Admin\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class RoleController extends Controller
{
    /**
     * 角色列表
     */
    public function index(Request $request)
    {
        $dataList = Role::orderBy('id', 'DESC')->get();
        return view('admin.role.index',['title' => '角色列表', 'dataList' => $dataList,]);
    }

    /**
     * 角色添加页面
     */
    public function add()
    {
        return view('admin.role.add');
    }

    /**
     * 角色添加方法
     */
    public function create()
    {
        $formData = request()->except('_token');

        //保存角色信息
        $obj = new Role();
        $obj->rolename = $formData['rolename'];
        $obj->sign = $formData['sign'];
        $res = $obj->save();

        if ($res) {
            $data = ['status' => 1, 'message' => '角色添加成功'];
        } else {
            $data = ['status' => 0, 'message' => '角色添加失败'];
        }
        return $data;
    }

    /**
     * 角色删除方法
     */
    public function delete()
    {
        //获取id
        $id = request()->get('id');

        //查询角色是否存在
        $data = Role::find($id);

        if ($data == null) {
            return ['status' => 0, 'message' => '未找到此角色或已被删除'];
        }

        //执行软删除 修改状态90
        $res = Role::where('id', $id)->update(['status' => '90']);

        if ($res == 1) {
            $data = ['status' => 1, 'message' => '角色已删除'];
        } else {
            $data = ['status' => 0, 'message' => '删除未成功'];
        }

        return $data;

    }

    /**
     * 角色修改页面
     */
    public function edit()
    {
        //获取id
        $id = request()->get('id');

        //查询此角色是否存在
        $data = Role::find($id);

        return view('admin.role.edit', ['data' => $data]);
    }

    /**
     * 角色修改方法
     */
    public function update()
    {
        $formData = request()->except('_token', 's');

        $role = Role::where('id', $formData['id'])->first();

        if ($role['rolename'] == $formData['rolename']) {
            if ($role['status'] == $formData['status']) {
                if ($role['sign'] == $formData['sign']) {
                    return ['status' => 0, 'message' => '暂无修改内容'];
                }
            }
        }

        $res = Role::where('id', $formData['id'])->update($formData);

        if ($res) {
            $data = ['status' => 1, 'message' => '角色修改成功'];
        } else {
            $data = ['status' => 0, 'message' => '角色修改失败'];
        }

        return $data;
    }

    /**
     * 获取授权页面
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function auth($id)
    {
        //获取当前的角色
        $role = Role::find($id);

        //获取所有的权限
        $perms = Permission::get();

        //获取当前用户拥有的权限
        $own_perms = $role->permission;
        $list = [];
        foreach ($own_perms as $v) {
            $list[] = $v->id;
        }

        return view('admin/role/auth', compact('role', 'perms', 'list'));
    }

    public function doAuth()
    {
        $formData = request()->except('_token', 's');

        //删除旧的权限
        DB::table('role_permission')->where('rid', $formData['role_id'])->delete();

        if (!empty($formData['pid'])) {
            //添加新的权限
            foreach ($formData['pid'] as $v) {
                DB::table('role_permission')->insert([
                    'rid' => $formData['role_id'],
                    'pid' => $v
                ]);

            }
        }

        return redirect('/admin/role')->with('success','权限已分配');

    }

}
