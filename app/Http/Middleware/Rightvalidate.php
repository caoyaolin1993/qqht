<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Rightvalidate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $res = $request->route()->action['controller'];
        $res = explode('\\', $res);
        $res = $res[count($res) - 1];
        $res = explode('@', $res);
        $controller = $res[0];
        $action = $res[1];
        $cur_menu = DB::table('admin_menus')->where('controller', $controller)->where('action', $action)->first();
        if (!$cur_menu) {
            return response('该功能不存在', 200);
        }
        // 当前登录的用户信息
        $admin = Auth::user();
        $group = DB::table('admin_group')->where('id', $admin->gid)->first();
        if (!$group) {
            return response('该角色不存在', 200);
        }
        if (!$group->rights) {
            $group->rights = [];
        } else {
            $group->rights = json_decode($group->rights, true);
        }
        //  判断当前要访问的菜单的id是否在权限数组中
        if (!in_array($cur_menu->id, $group->rights)) {
            return response('无权访问', 200);
        }
        return $next($request);
    }
}
