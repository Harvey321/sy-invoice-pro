<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Admin\Customer;
use App\Model\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class CustomerController extends Controller
{
    /**
     * 客户列表
     */
    public function index(Request $request)
    {
//        $query = new customer();
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
        $customerList = Customer::orderBy('id', 'DESC')->get();

        return view(
            'admin.customer.index',
            [
                'title' => '客户列表',
                'customerList' => $customerList,
            ]
        );
    }

    /**
     * 客户添加页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add()
    {
        return view('admin.customer.add');
    }

    /**
     * 客户添加方法
     */
    public function create()
    {
        $data = request()->except('_token');

        //判断密码输入密码是否一直
        if ($data['password'] != $data['pwd']) {
            return view('admin.customer.add', ['error_msg' => "<script type='text/javascript'>  toastr.error('两次密码输入请保持一致') </script>",]);
        }

        //文件上传 返回文件名/false
        $result = self::uploadFile($data);

        if ($result == false) {
            return view('admin.customer.add', ['error_msg' => "<script type='text/javascript'>  toastr.error('非法的文件格式') </script>",]);
        }

        //保存客户信息
        $customer_obj = new customer();
        $customer_obj->username = $data['username'];
        $customer_obj->password = md5($data['password']);
        $customer_obj->company = $data['company'];
        $customer_obj->address = $data['address'];
        $customer_obj->mobile = $data['mobile'];
        $customer_obj->contacts = $data['contacts'];
        $customer_obj->contacts_mobile = $data['contacts_mobile'];
        $customer_obj->contacts_email = $data['contacts_email'];
        $customer_obj->plan = $data['plan'];
        $customer_obj->topology_url = $data['topology_url'];
        $customer_obj->description = $data['description'];
        $res = $customer_obj->save();

        if ($res) {
            return view('admin.customer.add', ['error_msg' => "<script type='text/javascript'>  toastr.success('客户添加成功') </script>",]);
        } else {
            return view('admin.customer.add', ['error_msg' => "<script type='text/javascript'>  toastr.error('客户添加失败') </script>",]);
        }
    }

    /**
     * 生成唯一字符串为文件名
     * @return string
     */
    public function uuid()
    {
        //基于以微秒计的当前时间，生成一个唯一的 ID + 时间戳 + 5位的随机数
        return uniqid() . time() . mt_rand(10000, 99999);
    }

    /**
     * 上传文件
     */
    public function uploadFile(&$data)
    {
        //判断是否上传文件
        if ($_FILES["topology_url"]['error'] != 4) {

            // 允许上传的图片后缀
            $allowedExts = array("gif", "jpeg", "jpg", "png");

            //分割字符
            $temp = explode(".", $_FILES["topology_url"]["name"]);

            // 获取文件后缀名
            $extension = end($temp);

            //判断上传条件
            if ((($_FILES["topology_url"]["type"] == "image/gif")
                    || ($_FILES["topology_url"]["type"] == "image/jpeg")
                    || ($_FILES["topology_url"]["type"] == "image/jpg")
                    || ($_FILES["topology_url"]["type"] == "image/pjpeg")
                    || ($_FILES["topology_url"]["type"] == "image/x-png")
                    || ($_FILES["topology_url"]["type"] == "image/png"))
                && ($_FILES["topology_url"]["size"] < 204800)   // 小于 200 kb
                && in_array($extension, $allowedExts)) {

                //判断上传的文件是否错误
                if ($_FILES["topology_url"]["error"] > 0) {
                    return false;
                } else {

                    // upload/ + 新的文件名  =  url 保存文件路径
                    $file_name_url = "upload/" . self::uuid() . '.' . $extension;

                    //移动临时文件保存图片文件
                    move_uploaded_file($_FILES["topology_url"]["tmp_name"], $file_name_url);

                    //保存文件名
                    $data['topology_url'] = $file_name_url;

                    return true;
                    // 判断当前目录下的 upload 目录是否存在该文件
                    // 如果没有 upload 目录，你需要创建它，upload 目录权限为 777
                    // if (file_exists("upload/" . $_FILES["topology_url"]["name"])) {
                    //   echo $_FILES["topology_url"]["name"] . " 文件已经存在。 ";
                    //   } else {
                    //   // 如果 upload 目录不存在该文件则将文件上传到 upload 目录下
                    //     echo "文件存储在: " . "upload/" . $_FILES["topology_url"]["name"];
                    //  }
                }

            } else {
                return false;
            }

        } else {
            $data['topology_url'] = '';
            return true;
        }


    }


    /**
     * 客户删除方法
     */
    public function delete()
    {
        //获取id
        $id = request()->get('id');

        //查询客户是否存在
        $customer = Customer::find($id);

        if ($customer == null) {
            return ['status' => 0, 'success' => '未找到此客户或已被删除'];
        }

        //执行软删除 修改状态90
        $res = Customer::where('id', $id)->update(['status' => '90']);

        //执行成功
        if ($res == 1) {
            $data = ['status' => 1, 'message' => '客户已删除'];
        } else {
            $data = ['status' => 0, 'message' => '删除未成功'];
        }
        //执行失败
        return $data;

    }

    /**
     * 客户修改页面
     */
    public function edit()
    {
        //获取id
        $id = request()->get('id');

        //查询此客户是否存在
        $customer = customer::find($id);

        return view('admin.customer.edit', ['customer' => $customer]);
    }

    /**
     * 客户修改方法
     */
    public function update()
    {
        $data = request()->except('_token', 's');

        $customer = customer::find($data['id']);

        //如果传输密码与库内密码不同则说明密码进行过修改
        if ($data['password'] != $customer['password']) {
            $data['password'] = md5($data['password']);
        }

        //为空则说明没有上传   不为空则说明重新上传 调用上传文件方法
        if (!empty($_FILES["topology_url"]["name"])) {


//dump($_FILES["topology_url"]["name"]);
//dd($customer['topology_url']);
//            dd($_FILES["topology_url"]["name"] == $customer['topology_url']);


            //重新上传的时候 则需要删除源图片文件 不为空说明原来有图片那么要删除
            if (!empty($customer['topology_url'])) {
                //删除
                if (file_exists($customer['topology_url'])) {
                    $ending = unlink($customer['topology_url']);
                    if (!$ending) {
                        return view('admin.customer.edit', ['error_msg' => "<script type='text/javascript'>  toastr.error('文件上传失败') </script>",]);
                    }
                }
            }

            //文件上传 返回文件名/false
            $result = self::uploadFile($data);
            if ($result == false) {
                return back();
            }

        }

        $res = customer::where('id', $data['id'])->update($data);

        $customerList = Customer::orderBy('id', 'DESC')->get();

        if ($res) {

            return view(
                'admin.customer.index',
                [
                    'title' => '客户列表',
                    'customerList' => $customerList,
                    'error_msg' => "<script type='text/javascript'>  toastr.success('客户修改成功') </script>",
                ]
            );
        } else {
            return view(
                'admin.customer.index',
                [
                    'title' => '客户列表',
                    'customerList' => $customerList,
                    'error_msg' => "<script type='text/javascript'>  toastr.error('客户修改失败') </script>",
                ]
            );
        }

    }


    /**
     * 客户已购产品
     */
    public function purchased($id)
    {
        //获取当前客户
        $customer = Customer::find($id);

        //获取已购产品列表
        $product_list = $customer->product;


        return view('admin.customer.purchased', ['customer' => $customer, 'product_list' => $product_list]);
    }

    /**
     * 客户已购产品编辑
     */
    public function purchasedEdit($id)
    {
        $customer_product = DB::table('customer_product')->where('id', $id)->first();

        return view('admin.customer.purchasedProductEdit', ['customer_product' => $customer_product]);
    }


    /**
     * 客户已购产品编辑
     */
    public function purchasedUpdate()
    {

        $data = request()->except('_token', 's');

        $res = DB::table('customer_product')->where('id', $data['id'])->update($data);

        if ($res) {
            $data = ['status' => 1, 'message' => '客户修改成功'];
        } else {
            $data = ['status' => 0, 'message' => '客户修改失败'];
        }

        return $data;
    }

    /**
     * 客户已购产品删除
     */
    public function purchasedDelete($id)
    {
        $product = DB::table('customer_product')->where('id', $id)->first();
        if (empty($product)) {
            return ['status' => 0, 'success' => '未找到此产品或已被删除'];
        }

        $res = DB::table('customer_product')->where('id', $id)->update(['status' => 90]);

        //执行成功
        if ($res == 1) {
            $data = ['status' => 1, 'message' => '产品已删除'];
        } else {
            $data = ['status' => 0, 'message' => '删除未成功'];
        }
        //执行失败
        return $data;
    }

    public function purchasedAdd($customerId)
    {
        $productList = Product::all();
        dump($productList);

        return view('admin.customer.purchasedAdd',[
            'uid'=> $customerId,
            'productList'=>$productList,
        ]);
    }

    public function purchasedCreate()
    {
        $data = request()->except('_token');

        $temp = DB::table('customer_product')->where([['uid','=', $data['uid']],['pid','=',$data['pid']]])->get();
        if (isset($temp)){
            dump(123);
//            dd(123);
        }
//        dd($temp);

        $res = DB::table('customer_product')->insert($data);

        if ($res) {
            return view('admin.customer.add', ['error_msg' => "<script type='text/javascript'>  toastr.success('客户添加成功') </script>",]);
        } else {
            return view('admin.customer.add', ['error_msg' => "<script type='text/javascript'>  toastr.error('客户添加失败') </script>",]);
        }


    }

}
