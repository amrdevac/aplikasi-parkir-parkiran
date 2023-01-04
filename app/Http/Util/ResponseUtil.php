<?php

namespace App\Http\Util;

class ResponseUtil
{
    public static function successArray(?String $argMessage = "Proses Berhasil", $argData = [], ?int $argHttpStatus = 200)
    {
        return [
            "response_status" => "success",
            "message" => $argMessage,
            "data" => $argData,
            "http_status" => $argHttpStatus,
        ];
    }


    public static function failArray(?String $argMessage = "Proses Gagal", ?array $argData = [], ?int $argHttpStatus = 400)
    {
        return [
            "response_status" => "error",
            "message" => $argMessage,
            "data" => $argData,
            "http_status" => $argHttpStatus,
        ];
    }

    public static function applyJson($argApplyResponse)
    {
        return response()->json([
            "response_status" => $argApplyResponse["response_status"],
            "message" => $argApplyResponse["message"],
            "data" => $argApplyResponse["data"],
        ], $argApplyResponse["http_status"]);
    }
}
