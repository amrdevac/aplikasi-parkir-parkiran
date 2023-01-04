<?php

namespace App\Http\Service;

use App\Exceptions\FailException;
use App\Http\Util\ResponseUtil;
use Illuminate\Support\Facades\Auth;
use App\Http\Util\ResponseTextMessageUtil;

class VerifyService
{

    public static function byPassword($argVerifyRequest)
    {
        $username = auth()->user()->username;
        $password = $argVerifyRequest->password;

        $attemp_login = compact(
            "username",
            "password",
        );

        if (!password_verify($argVerifyRequest->password, auth()->user()->password)) {
            throw new FailException(
                ResponseUtil::failArray(
                    ResponseTextMessageUtil::$failVerifyDefault,
                    [],
                    400
                )
            );
        }
        return true;
    }

    public function byPasswordArray($argVerifyRequest)
    {
        $result =  $this->byPassword($argVerifyRequest);
        if ($result) {
            return ResponseUtil::successArray(
                ResponseTextMessageUtil::$successVerifyDefault,
                true,
                200
            );
        }

        return ResponseUtil::failArray(
            ResponseTextMessageUtil::$failVerifyDefault,
            [],
            400
        );
    }
}
