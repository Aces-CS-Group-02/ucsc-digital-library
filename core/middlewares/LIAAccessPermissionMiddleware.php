<?php

namespace app\core\middlewares;

use app\core\Application;
use app\core\exception\ForbiddenException;
use Exception;

class LIAAccessPermissionMiddleware extends BaseMiddleware
{
    public array $actions = [];

    public function __construct(array $actions = [])
    {
        $this->actions = $actions;
    }

    public function execute()
    {
        if ((int)Application::getUserRole() >= 2) {
            if (empty($this->actions) || in_array(Application::$app->controller->action, $this->actions)) {
                throw new ForbiddenException();
            }
        }
    }
}
