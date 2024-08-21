<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;

class ApiException extends Exception
{
    /* public function __construct($message = "", $code = 0, Exception $previous = null) */
    /* { */
    /*     parent::__construct($message, $code, $previous); */
    /* } */
    /* public function render(Request $request) */
    /* { */
    /*     return response()->json([ */
    /*         'error' => $this, */
    /*         'code' => $this->getCode(), */
    /*     ], 400); */
    /* } */
}
