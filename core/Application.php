<?php

namespace app\core;

use app\models\Notification;
use app\models\Role;
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
    public Role $roleModel;

    public function __construct($rootPath, array $config)
    {
        $this->userClass = $config['userClass'];
        self::$ROOT_DIR = $rootPath;
        self::$app = $this;
        $this->request = new Request();
        $this->response = new Response();
        $this->session = new Session();
        $this->router = new Router($this->request, $this->response);
        $this->roleModel = new Role();

        $this->db = new Database($config['db']);


        $primaryKeyValue = $this->session->get('user');
        if ($primaryKeyValue) {
            $primaryKey = $this->userClass::primaryKey();
            $this->user = $this->userClass::findOne([$primaryKey => $primaryKeyValue]);
        } else {
            $this->user = null;
        }

        /* 
        -------------------------------------------------------------------------
        \ Remove session when uri changes                                       \
        \ Here we remove session data we kept for some specifc pages            \ 
        -------------------------------------------------------------------------
        */
        if (strtolower($this->request->getPath()) !== '/admin/add-users' && $this->request->getMethod() !== 'POST') {
            Application::$app->session->remove('usergroup_bulk_selection_list');
        }
    }

    public function run()
    {
        echo $this->router->resolve();
        // try {
        //     echo $this->router->resolve();
        // } catch (Exception $e) {
        //     $this->response->setStatusCode($e->getCode());
        //     echo $this->router->renderView("error", ['exception' => $e]);
        // }
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
            return ['firstname' => self::$app->user->first_name, 'lastname' => self::$app->user->last_name];
        }
    }

    public static function getUserEmail()
    {
        if (self::$app->user) {
            return ['email' => self::$app->user->email];
        }
    }

    public function getUserRoleName()
    {
        return $this->roleModel->findOne(['role_id' => self::getUserRole()])->name ?? false;
    }

    public function getUserRoleNameByID($id)
    {
        return $this->roleModel->findOne(['role_id' => $id])->name ?? false;
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

    public static function getNotifications()
    {
        $notificationModel = new Notification();
        return $notifications = $notificationModel->getNotifications();
    }
}
