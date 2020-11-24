<?php

//验证码
Route::any('/code/captcha/{tmp}', 'Admin\LoginController@captcha');
//无权限页面
Route::any('/noAccess', 'Admin\LoginController@noAccess');
Route::any('/testxxx', function (){
    return view('test');
});


//前台相关路由
Route::any('/login', 'Reception\LoginController@index');//客户登录页
Route::any('/doLogin', 'Reception\LoginController@doLogin');//客户登录方法
Route::any('/loginOut', 'Reception\LoginController@loginOut');//退出登录

Route::group(['middleware' => ['customerIsLogin',]], function () {

    Route::any('/customer/product', 'Reception\CustomerController@index');//客户设备列表
    Route::any('/customer/product/add', 'Reception\CustomerController@add');//客户设别添加页
    Route::any('/customer/product/create', 'Reception\CustomerController@create');//客户设别添加
    Route::any('/customer/product/update', 'Reception\CustomerController@update');//客户设别修改
    Route::any('/customer/product/edit', 'Reception\CustomerController@edit');//客户设别修改页
    Route::any('/customer/product/delete', 'Reception\CustomerController@delete');//客户设备删除
    Route::any('/customer/product/details', 'Reception\CustomerController@details');//客户设备详情页
});





//官网路由
Route::prefix('/')->group(function () {

//走进双于
    Route::get('/', function () {
        return view('officialWeb.index');
    });


//产品及解决方案
    Route::get('/programme', function () {
        return view('officialWeb.programme');
    });

//企业简介
    Route::get('/introduce', function () {
        return view('officialWeb.introduce');
    });

//服务品质
    Route::get('/service', function () {
        return view('officialWeb.service');
    });

//联系我们
    Route::get('/contact', function () {
        return view('officialWeb.contact');
    });

    Route::get('/404', function () {
        return view('admin-end.404');
    });


    Route::get('/test', function () {
        return view('officialWeb.test');
    });
    Route::get('/test2', function () {
        return view('officialWeb.test2');
    });


    //联系我们
    Route::post('/getData', 'OfficialController@getData');
});




//后台相关路由
Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {
    Route::any('/login', 'LoginController@index');//登录页面
    Route::any('/doLogin', 'LoginController@doLogin');//登录方法
    Route::any('/loginOut', 'LoginController@loginOut');//退出登录
});


//后台相关路由- 登录之后进入 权限设置
Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['isLogin', 'hasRole']], function () {

    //用户路由
    Route::any('/user', 'UserController@index');//后台用户列表页
    Route::any('/user/add', 'UserController@add');//后台用户添加页
    Route::any('/user/create', 'UserController@create');//后台用户添加
    Route::any('/user/delete', 'UserController@delete');//后台用户删除
    Route::any('/user/edit', 'UserController@edit');//后台用户修改页
    Route::any('/user/update', 'UserController@update');//后台用户修改
    Route::any('/user/distributePage', 'UserController@distributePage');//后台用户分配角色页
    Route::any('/user/distribute', 'UserController@distribute');//后台用户分配角色

    //角色路由
    Route::any('/role', 'RoleController@index');//角色列表页
    Route::any('/role/add', 'RoleController@add');//角色添加页
    Route::any('/role/create', 'RoleController@create');//角色添加
    Route::any('/role/delete', 'RoleController@delete');//角色删除
    Route::any('/role/edit', 'RoleController@edit');//角色修改页
    Route::any('/role/update', 'RoleController@update');//角色修改
    Route::any('/role/auth/{id}', 'RoleController@auth');//授权页
    Route::any('/role/doAuth', 'RoleController@doAuth');//授权

    //权限路由
    Route::any('/permission', 'PermissionController@index');//权限列表页
    Route::any('/permission/add', 'PermissionController@add');//权限添加页
    Route::any('/permission/create', 'PermissionController@create');//权限添加
    Route::any('/permission/delete', 'PermissionController@delete');//权限删除
    Route::any('/permission/edit', 'PermissionController@edit');//权限修改页
    Route::any('/permission/update', 'PermissionController@update');//权限修改

    //产品路由
    Route::any('/product', 'ProductController@index');//产品列表页
    Route::any('/product/add', 'ProductController@add');//产品添加页
    Route::any('/product/create', 'ProductController@create');//产品添加
    Route::any('/product/delete', 'ProductController@delete');//产品删除
    Route::any('/product/edit', 'ProductController@edit');//产品修改页
    Route::any('/product/update', 'ProductController@update');//产品修改

    //客户路由
    Route::any('/customer', 'CustomerController@index');//后台客户列表页
    Route::any('/customer/add', 'CustomerController@add');//后台客户添加页
    Route::any('/customer/create', 'CustomerController@create');//后台客户添加
    Route::any('/customer/delete', 'CustomerController@delete');//后台客户删除
    Route::any('/customer/edit', 'CustomerController@edit');//后台客户修改页
    Route::any('/customer/update', 'CustomerController@update');//后台客户修改
    Route::get('/customer/purchased/{id}', 'CustomerController@purchased');//客户已购产品
    Route::any('/customer/purchased/edit/{id}', 'CustomerController@purchasedEdit');//客户已购产品修改页
    Route::any('/purchased/update', 'CustomerController@purchasedUpdate');//客户已购产品修改
    Route::any('/purchased/delete/{id}', 'CustomerController@purchasedDelete');//客户已购产品删除
    Route::any('/purchased/add/{id}', 'CustomerController@purchasedAdd');//客户已购产品添加
    Route::any('/purchased/create', 'CustomerController@purchasedCreate');//客户已购产品添加方法

    
    //发票路由
    Route::any('/invoice', 'InvoiceController@index');//发票列表页
    Route::any('/invoice/add', 'InvoiceController@add');//发票添加页
    Route::any('/invoice/create', 'InvoiceController@create');//发票添加
    Route::any('/invoice/delete', 'InvoiceController@delete');//发票删除
    Route::any('/invoice/edit', 'InvoiceController@edit');//发票修改页
    Route::any('/invoice/update', 'InvoiceController@update');//发票修改


});

