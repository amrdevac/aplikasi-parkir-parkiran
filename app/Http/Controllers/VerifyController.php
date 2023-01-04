<?php

namespace App\Http\Controllers;

use App\Http\Service\VerifyService;
use Illuminate\Http\Request;

class VerifyController extends Controller
{
    private VerifyService $verifyService;
    
    public function __construct()
    {
        $this->verifyService = new VerifyService;
    }

    public function verifyByPassword(Request $request)
    {
    }
}
