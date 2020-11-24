<?php

namespace App\Http\Controllers\Reception;

use App\Http\Controllers\Controller;
use App\Model\Admin\Customer;
use App\Model\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class CustomerController extends Controller
{
    /**
     * 客户设备列表
     */
    public function index()
    {
        //获取客户id
        $customerId = session()->get('customer')->id;

        //查询客户信息
        $customer = Customer::find($customerId);

        //获取客户名下的所有产品信息
        $productList = $customer->reception_product;

        //获取地区信息
        $belong_areas = [];

        //返回的客户产品信息
        $products = [];

        //查询的地区信息
        $address = '';

        if (request()->get('belong') == 'all' || empty(request()->get('belong'))) {
            self::dateFormat($productList, $belong_areas, $products, $address);
        }else{
            $address = request()->get('belong');
            self::dateFormat($productList, $belong_areas, $products, $address);
            $productList = $products;
        }

        return view('reception.customer.index', [
            'title' => '客户名下产品列表',
            'customer' => $customer,
            'productList' => $productList,
            'belong_areas' => $belong_areas,//产品地区列表
        ]);
    }

    public function dateFormat(&$productList, &$belong_areas, &$products, &$address)
    {
        foreach ($productList as $item) {
            $belong_areas[] = $item->pivot->belong_area;
            if ($address != ''){
                if ($item->pivot->belong_area == $address) {
                    $products[] = $item;
                }
            }
        }
        //地区信息去重
        $belong_areas = array_unique($belong_areas);
    }

    /**
     * 客户设备详情页
     */
    public function details()
    {
        //传递进来的是 关联表id
        $id = request()->except('s')['id'];

        //查询 客户对应的产品的 详情
        $customerProduct = DB::table('customer_product')->where('id', $id)->first();

        //查询产品内容
        $product = Product::where('id', $customerProduct->pid)->first();

        //将产品内容 补充进详情中
        $customerProduct->serial_num = $product->serial_num;
        $customerProduct->product_name = $product->product_name;
        $customerProduct->model = $product->model;


        return view(
            'reception.customer.details',
            [
                'customerProduct' => $customerProduct, // 产品的详情内容
            ]
        );


    }


    /**
     * 客户设备新增页
     */
    public function add()
    {
        return view('reception.customer.add');

    }

    /**
     * 客户设备新增连接点
     */
    public function create()
    {


    }


    /**
     * 客户设别修改方法
     */
    public function update()
    {
        //获取传递需要修改的客户产品 在关联表中的 id 和 name
        $formData = request()->except('s');

        //获取当前客户id
        $customerId = session()->get('customer')->id;

        //获取当前客户模型
        $customer = Customer::find($customerId);

        //查询当前客户所有的产品 以及 拥有的产品的详情属性
        $productList = $customer->reception_product;

        $customer_product_tmp = DB::table('customer_product')->where('id', $formData['id'])->first();

        if ($customer_product_tmp->name == $formData['name']) {
            return ['status' => 0, 'message' => '未修改产品名称'];
        }

        $res = DB::table('customer_product')->where('id', $formData['id'])->update(['name' => $formData['name']]);

        if ($res) {
            return ['status' => 1, 'message' => '修改成功'];

        }
        return ['status' => 0, 'message' => '修改失败'];

//        for ($i = 0; $i < count($productList); $i++) {
//            if ($formData['id'] == $productList[$i]->id) {
//                DB::table('customer_product')->update('name', $formData->name);
//            }
//        }
    }


    /**
     * 客户设备删除方法
     */
    public function delete()
    {
        //客户id
        $customerId = session()->get('customer')->id;

        //客户产品关联表id
        $id = request()->except('_token', 's')['id'];

        $res = DB::table('customer_product')->where('id', $id)->get();

        if ($res->isEmpty()) {
            return ['status' => 0, 'message' => '没有查询到此设备请联系客服人员'];
        }

        $result = DB::table('customer_product')
            ->where('id', $id)
            ->update(['device_status' => 90]);

        if ($result == 1) {
            return ['status' => 1, 'message' => '设备已删除'];
        }

    }


    /**
     * 修改页面暂时用不到
     */
    public function edit()
    {
    }

}