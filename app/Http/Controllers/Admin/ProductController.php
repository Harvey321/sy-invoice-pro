<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Product;
use Illuminate\Http\Request;


class ProductController extends Controller
{
    /**
     * 产品列表
     */
    public function index(Request $request)
    {
        $dataList = Product::orderBy('id', 'DESC')->get();

        foreach ($dataList as $item){

            //将多个json字符串分割为单个便利
            $temp_json =explode(",",$item['ip']);

            //每个json对
            $temp_arr = [];

            //每个json对 组装成一个arr数据 在存入
            $arr = [];

            foreach ($temp_json as $v){
                //将每个json对继续分割成数组
                $temp_arr = explode(":",$v);
                $arr[] = [
                    $temp_arr[0] => $temp_arr[1]
                ];
            }

            $item['ip'] = $arr;
        }

        return view(
            'admin.product.index',
            [
                'title' => '产品列表',
                'dataList' => $dataList,
            ]
        );
    }

    /**
     * 产品添加页面
     */
    public function add()
    {
        return view('admin.product.add');
    }

    /**
     * 产品添加方法
     */
    public function create()
    {
        $formData = request()->except('_token');
        //保存产品信息
        $obj = new Product();
        $obj->sn = $formData['sn'];
        $obj->product_name = $formData['product_name'];
        $obj->model = $formData['model'];
        $obj->address = $formData['address'];
        $obj->rate = $formData['rate'];
        $obj->ip = $formData['ip'];
        $obj->description = $formData['description'];
        $res = $obj->save();

        if ($res) {
            $data = ['status' => 1, 'message' => '产品添加成功'];
        } else {
            $data = ['status' => 0, 'message' => '产品添加失败'];
        }
        return $data;
    }

    /**
     * 产品删除方法
     */
    public function delete()
    {
        //获取id
        $id = request()->get('id');

        //查询产品是否存在
        $data = Product::find($id);

        if ($data == null) {
            return ['status' => 0, 'message' => '未找到此产品或已被删除'];
        }

        //执行软删除 修改状态90
        $res = Product::where('id', $id)->update(['status' => '90']);

        if ($res == 1) {
            $data = ['status' => 1, 'message' => '产品已删除'];
        } else {
            $data = ['status' => 0, 'message' => '删除未成功'];
        }

        return $data;

    }

    /**
     * 产品修改页面
     */
    public function edit()
    {
        //获取id
        $id = request()->get('id');

        //查询此产品是否存在
        $data = Product::find($id);

        return view('admin.product.edit', ['data' => $data]);
    }

    /**
     * 产品修改方法
     */
    public function update()
    {
        $formData = request()->except('_token', 's');

        $res = Product::where('id', $formData['id'])->update($formData);

        if ($res) {
            $data = ['status' => 1, 'message' => '产品修改成功'];
        } else {
            $data = ['status' => 0, 'message' => '产品修改失败'];
        }

        return $data;
    }

}
