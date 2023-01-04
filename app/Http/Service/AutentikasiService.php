<?php

namespace App\Http\Service;

use App\Models\User;
use App\Http\Util\ResponseUtil;
use App\Http\Util\SidebarMenuUtil;
use Illuminate\Support\Facades\Auth;
use App\Http\Util\ResponseTextMessageUtil;

class AutentikasiService
{
    private $secret = 'keeptryinbaby';
    private $selected_data = [
        "id",
        "name",
        "username",
    ];

    public function defaultLogin($argLogiParams)
    {
        $username = $argLogiParams->username;
        $password = $argLogiParams->password;

        $attemp_login = compact(
            "username",
            "password",
        );


        if (Auth::attempt($attemp_login)) {
            $dataUser = User::where('username', $username)->first(
                $this->selected_data
            );
            $success['token'] =  $dataUser->createToken($this->secret)->plainTextToken;

            $token = $dataUser->createToken($this->secret, [])->accessToken;
            $dataResponse = [
                "token" => $token,
                "data_user" => $dataUser,
                "menu_sidebar" => SidebarMenuUtil::$generalMenu,
            ];

            return ResponseUtil::successArray(
                ResponseTextMessageUtil::$successLoginDefault,
                $dataResponse,
                200
            );
        }
        return ResponseUtil::failArray(
            ResponseTextMessageUtil::$failLoginDefault,
            [],
            400
        );
        //     if (Auth::guard('web')->attempt($attemp_login, false, false)) {



        //         $token = $dataUser->createToken($this->secret, [])->accessToken;
        //         $dataResponse = [
        //             "token" => $token,
        //             "data_user" => $dataUser,
        //         ];
        //         return ResponseUtil::successArray(
        //             ResponseTextMessageUtil::$successLoginDefault,
        //             $dataResponse,
        //             200
        //         );
        //     }
        //     return ResponseUtil::failArray(
        //         ResponseTextMessageUtil::$failLoginDefault,
        //         [],
        //         401
        //     );
    }
}
