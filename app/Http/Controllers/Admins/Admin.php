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
            $title = DB::table('admin_group')->where('id',$value->gid)->get(['title'])->first();
            $res[$key]->gid = $title->title;
        }

        return json_encode(['code'  => 0, 'msg'  => '', 'count'  => 1000, 'data'  => $res]);
    }


    public function add()
    {
        return view('admins/admin/add');
    }

    public function save()
    {
        return view('admins/admin/save');
    }

    public function del()
    {
        return view('admins/admin/del');
    }
}
