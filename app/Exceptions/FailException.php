<?php

namespace App\Exceptions;

use App\Http\Util\ResponseUtil;
use Exception;

class FailException extends Exception
{
    private $errorResponse;

    public function __construct($errorResponse)
    {
        $this->errorResponse = $errorResponse;
    }
    public function render($request)
    {       
        return ResponseUtil::applyJson($this->errorResponse);
        // return response()->json(["error" => true, "message" => $this->getMessage()]);       
    }
}
