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
        $page = $request->page ? $request->page : 1;
        $limit = $request->limit ? $request->limit : 10;
        $data = $this->menustree(0);
        $count = count($data);
        $chunk_result = array_chunk($data, $limit);
        $index = ceil($count / $limit);
        if ($page > $index) {
            $page = 1;
        }
        $dataz = $chunk_result[$page - 1];
        return json_encode(['code' => 0, 'msg' => '', 'data' => $dataz, 'count' => $count]);
    }


    public function menustree($pid)
    {
        $data = DB::table('admin_menus')->where('pid', $pid)->lists();
        $arr = [];
        foreach ($data as $key => $value) {
            $dataa = DB::table('admin_menus')->where('pid', $value['id'])->lists();
            $arr[] = $data[$key];
            if ($dataa) {
                foreach ($dataa as $va) {
                    $va['title'] = '├─' . $va['title'];
                    $arr[]  = $va;
                    $datab = DB::table('admin_menus')->where('pid', $va['id'])->lists();
                    foreach ($datab as $vb) {
                        $vb['title'] = '├─' . $va['title'];
                        $arr[] = $vb;
                    }
                }
            }
        }
        return $arr;
    }

    public function add(Request $request)
    {
        if (!$request->ajax()) {
            $data['menus'] = $this->menustree(0);

            return view('admins/menus/add', $data);
        } else {
            $param['title'] = $request->title;
            $param['pid'] = (int)$request->pid;
            $param['controller'] = $request->controller;
            $param['action'] = $request->action ? $request->action:'';
            $param['ishidden'] = (int)$request->ishidden;
            $param['status'] = (int)$request->status;

            $res  = DB::table('admin_menus')->insertGetId($param);
            return json_encode(['code' => 0, 'msg' => '添加成功', 'id' => $res]);
        }
    }

    public function edit(Request $request)
    {
        if (!$request->ajax()) {
            $id = $request->id;
            $data['menus'] = $this->menustree(0);

            $data['info'] = DB::table('admin_menus')->where('id',$id)->item();

            return view('admins/menus/edit',$data);
        }else{
            $id = $request->id;
            $param['title'] = $request->title;
            $param['pid'] = $request->pid;
            $param['controller'] = $request->controller;
            $param['action'] = $request->action;
            $param['ishidden'] = $request->ishidden;
            $param['status'] = $request->status;

            DB::table('admin_menus')->where('id',$id)->update($param);

            return json_encode(['code' => 0, 'msg' => '修改成功']);
        }
    }

    public function del(Request $request)
    {
        $id = $request->id;
        DB::table('admin_menus')->where('id',$id)->delete();
        return json_encode(['code' => 0, 'msg' => '删除成功']);
    }

    public function detail(Request $request)
    {
        $id = $request->id;
        $res = DB::table('admin_menus')->where('id',$id)->item();
        return view('admins/menus/detail',$res);
    }


    public function upstatus(Request $request)
    {
        $id = (int)$request->id;
        $param['status'] = (int)$request->status;
        DB::table('admin_menus')->where('id', $id)->update($param);
        return json_encode(['code' => 0, 'msg' => '修改成功']);
    }

    public function upishidden(Request $request)
    {
        $id = (int)$request->id;
        $param['ishidden'] = (int)$request->ishidden;
        DB::table('admin_menus')->where('id', $id)->update($param);
        return json_encode(['code' => 0, 'msg' => '修改成功']);
    }

    public function editField(Request $request)
    {
        $type = $request->type;
        $id = $request->id;
        switch ($type) {
            case 'title':
                $param['title'] = $request->value;
                DB::table('admin_menus')->where('id', $id)->update($param);
                return json_encode(['code' => 0, 'msg' => '修改成功']);
                break;
            case 'controller':
                $param['controller'] = $request->value;
                DB::table('admin_menus')->where('id', $id)->update($param);
                return json_encode(['code' => 0, 'msg' => '修改成功']);
                break;
            case 'action':
                $param['action'] = $request->value;
                DB::table('admin_menus')->where('id', $id)->update($param);
                return json_encode(['code' => 0, 'msg' => '修改成功']);
                break;
            default:
                return json_encode(['code' => 1, 'msg' => '没有该字段']);
                break;
        }
    }
}
