<?php

use app\controllers\SiteController;
use app\controllers\AuthController;
use app\controllers\Communities;
use app\controllers\CommunitiesController;
use app\core\Application;
use app\core\Database;
use app\models\User;

require_once __DIR__ . "./../vendor/autoload.php";

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

$config = [
    'userClass' => User::class,
    'db' => [
        'dsn' => $_ENV['DB_DSN'],
        'user' => $_ENV['DB_USER'],
        'password' => $_ENV['DB_PASSWORD']
    ]
];

$app = new Application(dirname(__DIR__), $config);

$app->router->get('/', [SiteController::class, "home"]);

$app->router->get('/login', [AuthController::class, "login"]);
$app->router->post('/login', [AuthController::class, "login"]);

$app->router->get('/logout', [AuthController::class, "logout"]);

$app->router->get('/register', [AuthController::class, "register"]);
$app->router->post('/register', [AuthController::class, "register"]);

$app->router->get('/contact', [SiteController::class, "contact"]);
$app->router->post('/contact', [SiteController::class, "handleContact"]);

$app->router->get('/profile', [AuthController::class, "profile"]);




$app->router->get('/communities', [SiteController::class, "communities"]);
$app->router->get('/create-top-level-communities', [SiteController::class, "createTopLevelCommunities"]);
$app->router->post('/create-top-level-communities', [CommunitiesController::class, "createNewCommunity"]);


$app->router->post('/ajax/delete-top-level-community', [CommunitiesController::class, "deleteCommunity"]);


$app->router->get('/communities/update/community', [CommunitiesController::class, "update"]);
$app->router->post('/communities/update/community', [CommunitiesController::class, "update"]);




// $app->router->post('/communities', [CommunitiesController::class, "createNewCommunity"]);




$app->run();
