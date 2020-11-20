<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Admin\Permission;
use Illuminate\Http\Request;


class PermissionController extends Controller
{
    /**
     * 权限列表
     */
    public function index(Request $request)
    {
        $dataList = Permission::orderBy('id', 'DESC')->get();
        return view(
            'admin.permission.index',
            [
                'title' => '权限列表',
                'dataList' => $dataList,
            ]
        );
    }

    /**
     * 权限添加页面
     */
    public function add()
    {
        return view('admin.permission.add');
    }

    /**
     * 权限添加方法
     */
    public function create()
    {
        $formData = request()->except('_token');

        //保存权限信息
        $obj = new Permission();
        $obj->per_name = $formData['per_name'];
        $obj->per_url = $formData['per_url'];
        $res = $obj->save();

        if ($res) {
            $data = ['status' => 1, 'message' => '权限添加成功'];
        } else {
            $data = ['status' => 0, 'message' => '权限添加失败'];
        }
        return $data;
    }

    /**
     * 权限删除方法
     */
    public function delete()
    {
        //获取id
        $id = request()->get('id');

        //查询权限是否存在
        $data = permission::find($id);

        if ($data == null) {
            return ['status' => 0, 'message' => '未找到此权限或已被删除'];
        }

        //执行软删除 修改状态90
        $res = permission::where('id', $id)->update(['status' => '90']);

        if ($res == 1) {
            $data = ['status' => 1, 'message' => '权限已删除'];
        } else {
            $data = ['status' => 0, 'message' => '删除未成功'];
        }

        return $data;

    }

    /**
     * 权限修改页面
     */
    public function edit()
    {
        //获取id
        $id = request()->get('id');

        //查询此权限是否存在
        $data = permission::find($id);

        return view('admin.permission.edit', ['data' => $data]);
    }

    /**
     * 权限修改方法
     */
    public function update()
    {
        $formData = request()->except('_token', 's');

        $permission = Permission::where('id', $formData['id'])->first();

        if ($permission['per_name'] == $formData['per_name']) {
            if ($permission['per_url'] == $formData['per_url']) {
                if ($permission['status'] == $formData['status']) {
                    return ['status' => 0, 'message' => '暂无修改内容'];
                }
            }
        }

        $res = Permission::where('id', $formData['id'])->update($formData);

        if ($res) {
            $data = ['status' => 1, 'message' => '权限修改成功'];
        } else {
            $data = ['status' => 0, 'message' => '权限修改失败'];
        }

        return $data;
    }

}
