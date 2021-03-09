<?php

namespace App\Http\Controllers\Admins;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class Admin extends Controller
{
    public function index()
    {
        return view('admins/admin/index');
    }

    public function indexdata()
    {
        $res = DB::table('admin')->get(['id', 'username', 'realname', 'status', 'last_login', 'add_time', 'gid'])->all();

        foreach ($res as $key => $value) {
            $title = DB::table('admin_group')->where('id', $value->gid)->get(['title'])->first();
            $res[$key]->gid = $title->title;
        }

        return json_encode(['code'  => 0, 'msg'  => '', 'count'  => 1000, 'data'  => $res]);
    }

    // 修改 
    public function edit(Request $request)
    {
        if (!$request->ajax()) {
            $aid = (int)$request->aid;
            $data['item'] = DB::table('admin')->where('id', $aid)->item();
            // 角色列表  
            $data['groups'] = DB::table('admin_group')->lists();
            return view('admins/admin/edit', $data);
        } else {
            $param['username'] = $request->username;
            // $param['password'] = $request->password;
            $param['realname'] = $request->realname;
            $param['status'] = $request->status ? 1 : 0;
            $param['gid'] = (int)$request->gid;
            $aid = (int)$request->aid;

            DB::table('admin')->where('id', $aid)->update($param);
            return json_encode(['code' => 0, 'msg' => '修改成功']);
        }
    }

    public function add(Request $request)
    {
        if (!$request->ajax()) {
            $data['groups'] = DB::table('admin_group')->lists();

            return view('admins/admin/add', $data);
        } else {
            $param['username'] = $request->username;
            $param['password'] = password_hash($request->password,PASSWORD_DEFAULT);
            $param['realname'] = $request->realname;
            $param['gid'] = (int)$request->gid;
            $param['status'] = $request->status ? 1:0;
            $param['add_time'] = time();

            $res = DB::table('admin')->where('username',$param['username'])->item();

            if ($res) {
                return json_encode(['code' => 1, 'msg' => '用户名已存在']);
            }

            $res  = DB::table('admin')->insertGetId($param);
            return json_encode(['code' => 0, 'msg' => '添加成功']);
        }
    }

    public function save()
    {
        return view('admins/admin/save');
    }

    public function del(Request $request)
    {
        $id = (int)$request->id;
        DB::table('admin')->where('id', $id)->delete();
        return json_encode(['code' => 0, 'msg' => '删除成功']);
    }

    public function detail(Request $request)
    {
        $aid = (int)$request->aid;
        $res = DB::table('admin')->where('id', $aid)->item();
        return view('admins/admin/detail', $res);
    }

    public function upstatus(Request $request)
    {
        $param['status'] = $request->status;
        $id = $request->id;
        DB::table('admin')->where('id',$id)->update($param);
        return json_encode(['code' => 0, 'msg' => '修改成功']);
    }
}
