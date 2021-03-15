<?php

namespace App\Http\Controllers\Admins;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class Role extends Controller
{
    public function index(Request $request)
    {
        return view('admins/role/index');
    }

    public function indexdata(Request $request)
    {
        $res = DB::table('admin_group')->lists();
        $count = DB::table('admin_group')->count();

        return json_encode(['code' => 0, 'msg' => '', 'data'  => $res, 'count'  => $count]);
    }


    public function setrole(Request $request)
    {

        // $data['rights'] = json_decode($res['rights'], true);
        // $obja = new Menus();
        // $data['menus'] = $obja->menustree(0);

        $data['id'] = $request->id;

        $group = json_decode(DB::table('admin_group')->where('id', $data['id'])->item()['rights'], true);

        $data['group'] = implode(',', $group);


        return view('admins/role/setrole', $data);
    }

    public function setroledata(Request $request)
    {
        $res = DB::table('admin_menus')->where('pid', 0)->lists();
        $arr = [];
        foreach ($res as $key => $value) {
            $resa = DB::table('admin_menus')->where('pid', $value['id'])->lists();
            if ($resa) {
                foreach ($resa as $keya => $valuea) {
                    $arr[$key]['id'] =  $value['id'];
                    $arr[$key]['label'] =  $value['title'];
                    $arr[$key]['children'][$keya] = [
                        'id' => $valuea['id'],
                        'label' => $valuea['title']
                    ];
                }
            } else {
                $arr[$key] = [
                    'id' => $value['id'],
                    'label'  => $value['title'],
                ];
            }
        }
        return json_encode(['code' => 0, 'msg' => '', 'data' => $arr], JSON_UNESCAPED_UNICODE);
    }

    public function roletj(Request $request)
    {
        $data = $request->data;
        $id = $request->id;
        foreach ($data as $key => $value) {
            $data[$key] = (int)$value;
        }
        $data = json_encode($data);

        DB::table('admin_group')->where('id',$id)->update(['rights'=>$data]);

        return json_encode(['code' => 0, 'msg' => '保存成功'],JSON_UNESCAPED_UNICODE);
        
    }

    public function subright(Request $request)
    {
        $param['rights'] = $request->rights ? json_encode(array_values($request->rights)) : "[]";

        dd($param);
    }
}
