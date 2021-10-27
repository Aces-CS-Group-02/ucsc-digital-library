<?php

use app\controllers\AdministrationController;
use app\controllers\ApproveController;
use app\controllers\SiteController;
use app\controllers\AuthController;
use app\controllers\CollectionController;
use app\controllers\UserController;
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

$app->router->get('/logout', [AuthController::class, "logout"]);

$app->router->get('/forgot-password', [AuthController::class, "forgotPassword"]);
$app->router->post('/forgot-password', [AuthController::class, "forgotPassword"]);

//Authentication routes
$app->router->get('/register', [AuthController::class, "register"]);
$app->router->post('/register', [AuthController::class, "register"]);
// $app->router->get('/registration-request', [AuthController::class, "registerRequest"]);
$app->router->post('/registration-request', [AuthController::class, "registerRequest"]);
$app->router->get('/verify-email',[AuthController::class, "verifyEmail"]);
$app->router->post('/verify-email',[AuthController::class, "verifyEmail"]);
$app->router->get('/reset-password',[AuthController::class, "resetPassword"]);
$app->router->post('/reset-password',[AuthController::class, "resetPassword"]);


$app->router->get('/contact', [SiteController::class, "contact"]);
$app->router->post('/contact', [SiteController::class, "handleContact"]);

$app->router->get('/profile', [AuthController::class, "profile"]);





// Communities & Sub communities
$app->router->get('/admin/manage-communities', [CommunitiesController::class, "communities"]);
$app->router->get('/admin/create-top-level-community', [CommunitiesController::class, "createTopLevelCommunities"]);
$app->router->post('/admin/create-top-level-community', [CommunitiesController::class, "createNewCommunity"]);
$app->router->post('/ajax/delete-top-level-community', [CommunitiesController::class, "deleteCommunity"]);
$app->router->get('/admin/edit-community', [CommunitiesController::class, "update"]);
$app->router->post('/admin/edit-community', [CommunitiesController::class, "update"]);
$app->router->get('/admin/manage-community', [CommunitiesController::class, "manage"]);
$app->router->get('/admin/create-sub-community', [CommunitiesController::class, "createSubCommunity"]);
$app->router->post('/admin/create-sub-community', [CommunitiesController::class, "createNewSubCommunity"]);


// Community Collections
$app->router->get('/admin/manage-community/collections', [CollectionController::class, "manageCollections"]);
$app->router->get('/admin/create-collection', [CollectionController::class, "createCollection"]);
$app->router->post('/admin/create-collection', [CollectionController::class, "createCollection"]);
$app->router->post('/ajax/delete-community-collection', [CollectionController::class, "deleteCollection"]);


//User routes
$app->router->get('/profile', [UserController::class, "profile"]);


// Create, Remove LIA
$app->router->get('/admin/manage-library-information-assistant', [AdministrationController::class, "manageLibraryInformationAssistant"]);
$app->router->post('/admin/manage-library-information-assistant', [AdministrationController::class, "removeLibraryInformationAssistant"]);
$app->router->get('/admin/create-library-information-assistant', [AdministrationController::class, "createLibraryInformationAssistant"]);
$app->router->post('/admin/create-library-information-assistant', [AdministrationController::class, "createLibraryInformationAssistant"]);


// Admin Dashboard Routes
$app->router->get('/admin/dashboard', [AdministrationController::class, "adminDashboard"]);
$app->router->get('/admin/dashboard/manage-content', [AdministrationController::class, "manageContentDashboard"]);
$app->router->get('/admin/dashboard/manage-users', [AdministrationController::class, "manageUsersDashboard"]);
$app->router->get('/admin/dashboard/manage-approvals', [AdministrationController::class, "manageApprovalsDashboard"]);


// Admin Dashboard => Manage Content Routes
$app->router->get('/admin/upload-content', [AdministrationController::class, "uploadContent"]);
$app->router->get('/admin/bulk-upload', [AdministrationController::class, "bulkUpload"]);
$app->router->get('/admin/publish-content', [AdministrationController::class, "publishContent"]);
$app->router->get('/admin/unpublish-content', [AdministrationController::class, "unpublishContent"]);
$app->router->get('/admin/edit-metadata', [AdministrationController::class, "editMetadata"]);
$app->router->get('/admin/remove-content', [AdministrationController::class, "removeContent"]);


// Admin Dashboard => Manage Users Routes
$app->router->get('/admin/bulk-register', [AdministrationController::class, "bulkRegister"]);
$app->router->post('/admin/bulk-register', [AdministrationController::class, "bulkRegister"]);
$app->router->get('/admin/verify-new-users', [ApproveController::class, "approveNewUser"]);
$app->router->get('/admin/users', [AdministrationController::class, "manageUsers"]);


// Still Implementing
// $app->router->get('/admin/create-user-group', [AdministrationController::class, "createUserGroup"]);
// $app->router->post('/admin/create-user-group', [AdministrationController::class, "createUserGroup"]);
// $app->router->get('/admin/create-user-group/add-users', [AdministrationController::class, "addUsersToUserGroup"]);
// $app->router->post('/ajax/push-user-to-user-group', [AdministrationController::class, "pushUserToUserGroup"]);
// $app->router->post('/ajax/push-users-to-user-group', [AdministrationController::class, "pushUsersToUserGroup"]);
// $app->router->post('/admin/create-user-group/review', [AdministrationController::class, "reviewUserGroup"]);
// $app->router->get('/admin/manage-user-groups', [AdministrationController::class, "manageUserGroup"]);
// $app->router->get('/admin/manage-my-user-groups', [AdministrationController::class, "manageMyUserGroups"]);
// $app->router->get('/admin/add-users', [AdministrationController::class, "addUsersToUserGroup"]);


$app->router->get('/admin/approve-content-groups', [AdministrationController::class, "approveContentGroup"]);
$app->router->get('/admin/approve-user-groups', [AdministrationController::class, "approveUserGroup"]);






































// $app->router->post('/manage/community', [CommunitiesController::class, "update"]);





// $app->router->post('/communities', [CommunitiesController::class, "createNewCommunity"]);




$app->run();
