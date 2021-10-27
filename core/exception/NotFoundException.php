<?php

namespace app\core\exception;

use Exception;

class NotFoundException extends Exception
{

    protected $message = 'OOPS... Page not found';
    protected $code = 404;
}
