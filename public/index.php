<?php

use app\controllers\AdministrationController;
use app\controllers\ApproveController;
use app\controllers\SiteController;
use app\controllers\AuthController;
use app\controllers\UserController;
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
$app->router->get('/search', [SiteController::class, "search"]);
$app->router->get('/browse', [SiteController::class, "browse"]);

$app->router->get('/login', [AuthController::class, "login"]);
$app->router->post('/login', [AuthController::class, "login"]);

$app->router->post('/logout', [AuthController::class, "logout"]);

$app->router->get('/forgot-password', [AuthController::class, "forgotPassword"]);
$app->router->post('/forgot-password', [AuthController::class, "forgotPassword"]);


$app->router->get('/register', [AuthController::class, "register"]);
$app->router->post('/register', [AuthController::class, "register"]);
// $app->router->get('/registration-request', [AuthController::class, "registerRequest"]);
$app->router->post('/registration-request', [AuthController::class, "registerRequest"]);
$app->router->get('/verify-email',[AuthController::class, "verifyEmail"]);
$app->router->post('/verify-email',[AuthController::class, "verifyEmail"]);


$app->router->get('/contact', [SiteController::class, "contact"]);
$app->router->post('/contact', [SiteController::class, "handleContact"]);

$app->router->get('/profile', [AuthController::class, "profile"]);




$app->router->get('/manage/communities', [SiteController::class, "communities"]);
$app->router->get('/create-top-level-communities', [SiteController::class, "createTopLevelCommunities"]);
$app->router->post('/create-top-level-communities', [CommunitiesController::class, "createNewCommunity"]);


$app->router->post('/ajax/delete-top-level-community', [CommunitiesController::class, "deleteCommunity"]);


$app->router->get('/communities/update/community', [CommunitiesController::class, "update"]);
$app->router->post('/communities/update/community', [CommunitiesController::class, "update"]);


$app->router->get('/manage/community', [CommunitiesController::class, "manage"]);
$app->router->get('/create-sub-community', [SiteController::class, "createSubCommunity"]);
$app->router->post('/create-sub-community', [CommunitiesController::class, "createNewSubCommunity"]);



//User routes
$app->router->get('/profile', [UserController::class, "profile"]);


$app->router->get('/admin/manage-library-information-assistant', [SiteController::class, "manageLibraryInformationAssistant"]);
$app->router->post('/admin/manage-library-information-assistant', [AdministrationController::class, "removeLibraryInformationAssistant"]);

$app->router->get('/admin/create-library-information-assistant', [SiteController::class, "createLibraryInformationAssistant"]);
$app->router->post('/admin/create-library-information-assistant', [AdministrationController::class, "createLibraryInformationAssistant"]);




// Admin Routes
$app->router->get('/admin/dashboard', [AdministrationController::class, "adminDashboard"]);
$app->router->get('/admin/dashboard/manage-content', [AdministrationController::class, "manageContentDashboard"]);
$app->router->get('/admin/dashboard/manage-users', [AdministrationController::class, "manageUsersDashboard"]);
$app->router->get('/admin/dashboard/manage-approvals', [AdministrationController::class, "manageApprovalsDashboard"]);


$app->router->get('/admin/upload-content', [AdministrationController::class, "uploadContent"]);
$app->router->get('/admin/bulk-upload', [AdministrationController::class, "bulkUpload"]);
$app->router->get('/admin/publish-content', [AdministrationController::class, "publishContent"]);
$app->router->get('/admin/unpublish-content', [AdministrationController::class, "unpublishContent"]);
$app->router->get('/admin/edit-metadata', [AdministrationController::class, "editMetadata"]);
$app->router->get('/admin/remove-content', [AdministrationController::class, "removeContent"]);


$app->router->get('/admin/bulk-register', [AdministrationController::class, "bulkRegister"]);
$app->router->post('/admin/bulk-register', [AdministrationController::class, "bulkRegister"]);
$app->router->get('/admin/verify-new-users', [ApproveController::class, "approveNewUser"]);
$app->router->get('/admin/users', [AdministrationController::class, "manageUsers"]);
$app->router->get('/admin/create-user-group', [AdministrationController::class, "createUserGroup"]);
$app->router->post('/admin/create-user-group/add-users', [AdministrationController::class, "addUsersToUserGroup"]);
$app->router->post('/admin/create-user-group/review', [AdministrationController::class, "reviewUserGroup"]);
$app->router->get('/admin/manage-user-groups', [AdministrationController::class, "manageUserGroup"]);


$app->router->get('/admin/approve-content-groups', [AdministrationController::class, "approveContentGroup"]);
$app->router->get('/admin/approve-user-groups', [AdministrationController::class, "approveUserGroup"]);





























// $app->router->post('/manage/community', [CommunitiesController::class, "update"]);





// $app->router->post('/communities', [CommunitiesController::class, "createNewCommunity"]);




$app->run();
