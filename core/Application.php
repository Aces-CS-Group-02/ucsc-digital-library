<?php

namespace app\core;

use Exception;

class Application
{

    public static string $ROOT_DIR;

    public string $userClass;
    public Router $router;
    public Request $request;
    public Response $response;
    public Session $session;
    public static Application $app;
    public Database $db;
    public ?DbModel $user;
    public ?Controller $controller = null;

    public function __construct($rootPath, array $config)
    {
        $this->userClass = $config['userClass'];
        self::$ROOT_DIR = $rootPath;
        self::$app = $this;
        $this->request = new Request();
        $this->response = new Response();
        $this->session = new Session();
        $this->router = new Router($this->request, $this->response);

        $this->db = new Database($config['db']);


        $primaryKeyValue = $this->session->get('user');
        if ($primaryKeyValue) {
            $primaryKey = $this->userClass::primaryKey();
            $this->user = $this->userClass::findOne([$primaryKey => $primaryKeyValue]);
        } else {
            $this->user = null;
        }
    }

    public function run()
    {
        // echo $this->router->resolve();
        try {
            echo $this->router->resolve();
        } catch (Exception $e) {
            $this->response->setStatusCode($e->getCode());
            echo $this->router->renderView("error", ['exception' => $e]);
        }
    }

    public function login(DbModel $user)
    {
        $this->user = $user;
        $primaryKey = $this->user->primaryKey();
        $primaryKeyValue = $user->{$primaryKey};
        $this->session->set('user', $primaryKeyValue);
        return true;
    }

    public static function isGuest()
    {
        return !self::$app->user;
    }

    public static function getUserDisplayName()
    {
        if (self::$app->user) {
            return ['firstname' => self::$app->user->firstname, 'lastname' => self::$app->user->lastname];
        }
    }

    public static function getUserRole()
    {
        return self::$app->user->role_id ?? false;
    }

    public function logout()
    {
        $this->user = null;
        $this->session->remove('user');
    }
}
