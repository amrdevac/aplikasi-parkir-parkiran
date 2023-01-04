<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Util\ResponseUtil;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

// Ngejar waktu , ga pake layer service
class KaryawanController extends Controller
{
    public function index(Request $request)
    {
        $query = DB::table("users");
        if ($request->pencarian) {
            $query->where("name", "LIKE", "%" . $request->pencarian . "%");
        }

        $in_karyawan =  $query->get();

        $totalKarywanAll =  $in_karyawan->count();
        $totalKaryawanAdmin =  $in_karyawan->where("role", 1)->count();
        $totalKaryawanUsers =  $in_karyawan->where("role", 0)->count();

        $dataResponse = compact(
            "totalKarywanAll",
            "in_karyawan",
            "totalKaryawanAdmin",
            "totalKaryawanUsers",
        );

        $response = ResponseUtil::successArray(null, $dataResponse);
        return ResponseUtil::applyJson($response);
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            "name" => "required",
            "username" => "required",
            "role" => "required",
            "status" => "required",
        ]);

        $in_karyawan = DB::table("users")->where("id", $request->id)->update([
            "name" => $request->name,
            "username" => $request->username,
            "role" => $request->role,
            "status" => $request->status,
        ]);

        $response = ResponseUtil::successArray("Berhasil Memperbarui Data Karyawan", $in_karyawan);
        return ResponseUtil::applyJson($response);
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            "name" => "required",
            "username" => "required",
            "role" => "required",
            "status" => "required",
        ]);

        $in_karyawan = DB::table("users")->insert([
            "name" => $request->name,
            "username" => $request->username,
            "email_verified_at" => date("Y-m-d H:i:s"),
            "role" => $request->role,
            "status" => $request->status,
            "password" => Hash::make("password")
        ]);

        $response = ResponseUtil::successArray("Berhasil Menambahkan Karyawan", $in_karyawan);
        return ResponseUtil::applyJson($response);
    }

    public function delete(Request $request)
    {
        $in_karyawan = DB::table("users")->where("id", $request->id)->delete();
        $response = ResponseUtil::successArray("Berhasil Menghapus Karyawan", $in_karyawan);
        return ResponseUtil::applyJson($response);
    }
}
