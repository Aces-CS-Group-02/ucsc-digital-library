<?php

namespace app\core\exception;

use Exception;

class ForbiddenException extends Exception
{
    protected $code = 403;
    protected $message = "You can't access this page";
}
