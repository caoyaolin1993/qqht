<?php

namespace App\Http\Controllers\Admins;

use Pcic\Pcic;
use Pcic\PcicException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class Account extends Controller
{
    // 登录
    public function login()
    {
        return view('admins/account/login');
    }

    // 执行登录
    public function dologin(Request $request)
    {
        $username = $request->username;
        $pwd = $request->pwd;
        $captcha = $request->captcha;
        if ($captcha=='') {
            return json_encode(['code' => 1, 'msg' => '验证码不能为空']);
        }
        session_start();
        if (strtolower($captcha) != strtolower($_SESSION['code'])) {
            return json_encode(['code' => 1, 'msg' => '验证码错误']);
        }
        // 认证用户
        $isok = Auth::attempt(['username' => $username, 'password' => $pwd]);

        if (!$isok) {
            return json_encode(['code' => 1, 'msg' => '登录失败']);
        }
        // $res = DB::table('admin')->where('username', $username)->first();
        // if ($res->status == 1) {
        //     return json_encode(['code' => 1, 'msg' => '该用户已被禁用']);
        // }
        $admin = Auth::user();
        if ($admin->status) {
            return json_encode(['code' => 0, 'msg' => '该用户已被禁用']);
        }
        return json_encode(['code' => 0, 'msg' => '登录成功']);
    }


    // 退出登录
    public function logout()
    {
        Auth::logout();
        return json_encode(['code'=>0,'msg'=>'退出成功']);
    }


    public function captcha(Request $request)
    {
        try {
            $code = $this->getRandStr(4);
            session_start();
            $_SESSION['code'] = $code;
            Pcic::createCaptchaImage($code);
        } catch (PcicException $e) {
            echo $e->getMessage();
        }
    }

    private function getRandStr($length)
    {
        //字符组合
        $str = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $len = strlen($str) - 1;
        $randstr = '';
        for ($i = 0; $i < $length; $i++) {
            $num = mt_rand(0, $len);
            $randstr .= $str[$num];
        }
        return $randstr;
    }
}
