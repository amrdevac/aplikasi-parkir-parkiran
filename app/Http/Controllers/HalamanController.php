<?php

namespace App\Http\Controllers;

use App\Http\Util\SidebarMenuUtil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HalamanController extends Controller
{
    public function __invoke()
    {
        $in_sidebars = [];
        if (Auth::check()) {
            $in_sidebars = SidebarMenuUtil::$generalUserMenu;
            if (auth()->user()->role == 1) {
                $in_sidebars =  SidebarMenuUtil::$generalMenu;
            }
        }

        return view("layouts.app", compact("in_sidebars"));
    }
}
