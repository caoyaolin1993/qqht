<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Setting extends Controller
{
    public function index()
    {
        return view('admins/setting/index');
    }
}
