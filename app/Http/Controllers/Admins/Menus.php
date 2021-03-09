<?php

namespace App\Http\Controllers\Admins;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class Menus extends Controller
{
    public function index()
    {
        return view('admins/menus/index');
    }

    public function indexdata(Request $request)
    {
        $data = DB::table('admin_menus')->lists();

        $count = DB::table('admin_menus')->count();

        return json_encode(['code' => 0, 'msg' => '','data'=>$data,'count'=>$count]);
    }
}
