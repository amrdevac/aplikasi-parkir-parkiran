<?php

namespace App\Http\Util;

class DefaultValue
{
    public static function arrTimestamps()
    {
        return [
            "created_at" => date("Y-m-d H:i:s"),
            "updated_at" => date("Y-m-d H:i:s"),
        ];
    }
}
