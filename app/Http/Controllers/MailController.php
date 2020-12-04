<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use PhpParser\Node\Stmt\Global_;

class MailController extends Controller
{
    /**
     * @param null $title 邮件标题
     * @param null $email 发送的地址
     * @param null $name 用户名
     * @param null $temp_address 发送附件的地址
     * @param null $file_name 文件名
     * @return bool 返回发送状态
     */
    public function send($title = null, $email = null, $name = null, $temp_address = null, $file_name = null)
    {
        Mail::send('emails.index', ['name' => $name], function ($message) use ($title, $email, $name, $temp_address, $file_name) {

            $message->to($email)->subject($title);

            $message->attach($temp_address, ['as' => $file_name]);

        });

        if (empty(Mail::failures())) {
            return false;
        }
        return true;
    }
}

