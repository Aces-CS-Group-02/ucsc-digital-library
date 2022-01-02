<?php

namespace app\core\exception;

use Exception;

class ForbiddenException extends Exception
{
    protected $code = 403;
    protected $message = "Sorry, but you don't have permission to access this page";
}
