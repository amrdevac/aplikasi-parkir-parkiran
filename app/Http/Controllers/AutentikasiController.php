<?php

namespace App\Http\Controllers;

use App\Http\Repository\LoginRepository;
use App\Http\Service\AutentikasiService;
use App\Http\Util\ResponseUtil;
use Illuminate\Http\Request;
use stdClass;

class AutentikasiController extends Controller
{
    private AutentikasiService $authService;

    public function __construct()
    {
        $this->authService = new AutentikasiService;
    }

    public function loginDefault(Request $request)
    {
        $this->validate($request, [
            "username" => "required",
            "password" => "required",
        ]);

        $argLoginParams = new stdClass;
        $argLoginParams->username = $request->username;
        $argLoginParams->password = $request->password;

        $loginResult = $this->authService->defaultLogin($argLoginParams);
        return ResponseUtil::applyJson($loginResult);
    }
}
