<?php

namespace App\Http\Util;


class SidebarMenuUtil
{
    public static $generalMenu = [
        [
            "link" => "/dashboard",
            "name" => "Dashboard",
            "icon" => "",
        ],
        [
            "link" => "/parking-in",
            "name" => "Masuk Parkir",
            "icon" => "fa-arrow-circle-o-right",
        ],
        [
            "link" => "/parking-out",
            "name" => "Keluar Parkir",
            "icon" => "fa-arrow-circle-o-left",
        ],
        [
            "link" => "/parking-list",
            "name" => "Laporan Parkir",
            "icon" => "",
        ],
        [
            "link" => "/karyawan",
            "name" => "Karyawan",
            "icon" => "fa-users",
        ],
    ];


    public static $generalUserMenu = [
        [
            "link" => "/dashboard",
            "name" => "Dashboard",
            "icon" => "",
        ],
        [
            "link" => "/parking-in",
            "name" => "Masuk Parkir",
            "icon" => "fa-arrow-circle-o-right",
        ],
        [
            "link" => "/parking-out",
            "name" => "Keluar Parkir",
            "icon" => "fa-arrow-circle-o-left",
        ],
    ];
}
