<?php

namespace App\Http\Controllers\Admins;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class Home extends Controller
{
    public function index()
    {
        // 管理员信息
        $data['admin'] = Auth::user();
        $gid = $data['admin']->gid;
        $res = DB::table('admin_group')->where('id', $gid)->select('title', 'rights')->first();
        $res->rights = json_decode($res->rights, true);
        $data['admin']->group_title = $res->title;

        // 加载菜单
        $data['menus'] = DB::table('admin_menus')->where('pid', 0)->where('ishidden', 0)->where('status', 0)->whereIn('id', $res->rights)->get()->all();

        foreach ($data['menus'] as $key => $value) {
            $childs = DB::table('admin_menus')->where('pid', $value->id)->where('ishidden', 0)->where('status', 0)->whereIn('id', $res->rights)->get()->all();
            $data['menus'][$key]->childs = $childs;
        }

        /*      $data['menus'] = DB::table('admin_menus')->where('pid', 0)->where('ishidden', 0)->where('status', 0)->get()->all();
        foreach ($data['menus'] as $key => $value) {
            $childs = DB::table('admin_menus')->where('pid', $value->id)->where('ishidden', 0)->where('status', 0)->get()->all();
            $data['menus'][$key]->childs = $childs;
        }
 */

        return view('admins/home/index', $data);
    }

    public function welcome()
    {
        return view('admins/home/welcome');
    }
}
