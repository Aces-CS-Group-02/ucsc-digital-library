<?php

use app\controllers\AdministrationController;
use app\controllers\ApproveController;
use app\controllers\SiteController;
use app\controllers\AuthController;
use app\controllers\CollectionController;
use app\controllers\UserController;
use app\controllers\CommunitiesController;
use app\controllers\ContentController;
use app\controllers\DummyController;
use app\controllers\UsergroupController;
use app\controllers\PermissionsController;
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
$app->router->get('/advanced-search', [SiteController::class, "advancedSearch"]);

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
$app->router->get('/verify-email', [AuthController::class, "verifyEmail"]);
$app->router->post('/verify-email', [AuthController::class, "verifyEmail"]);
$app->router->get('/reset-password', [AuthController::class, "resetPassword"]);
$app->router->post('/reset-password', [AuthController::class, "resetPassword"]);


$app->router->get('/contact', [SiteController::class, "contact"]);
$app->router->post('/contact', [SiteController::class, "handleContact"]);

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
$app->router->get('/profile/edit', [UserController::class, "editProfile"]);
$app->router->get('/profile/create-user-collection', [UserController::class, "userCollection"]);
$app->router->post('/profile/create-user-collection', [UserController::class, "createNewUserCollection"]);
$app->router->get('/profile/my-collections', [UserController::class, "userCollections"]);
// $app->router->post('/profile/my-collections', [UserController::class, "userCollections"]);
$app->router->get('/profile/manage-collection-view', [UserController::class, "manageCollectionTest"]);
$app->router->get('/profile/manage-collection', [UserController::class, "manageCollection"]);
$app->router->get('/profile/pdf-viewer', [UserController::class, "pdfViewer"]);
$app->router->get('/profile/video-player', [UserController::class, "videoPlayer"]);
$app->router->get('/suggest-content', [UserController::class, "suggestContent"]);
$app->router->post('/suggest-content', [UserController::class, "createContentSuggestion"]);


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
$app->router->get('/admin/upload-content', [ContentController::class, "uploadContent"]);
$app->router->post('/admin/upload-content', [ContentController::class, "uploadContent"]);
$app->router->get('/admin/upload-content/metadata', [ContentController::class, "updateMetadata"]);
$app->router->post('/admin/upload-content/metadata', [ContentController::class, "updateMetadata"]);
$app->router->get('/admin/upload-content/insert-keyword-abstract', [ContentController::class, "updateKeywordAbstract"]);
$app->router->post('/admin/upload-content/insert-keyword-abstract', [ContentController::class, "updateKeywordAbstract"]);
$app->router->get('/admin/upload-content/upload-file', [ContentController::class, "uploadFile"]);
$app->router->post('/admin/upload-content/upload-file', [ContentController::class, "uploadFile"]);
$app->router->get('/admin/upload-content/verify', [ContentController::class, "verify"]);
$app->router->post('/admin/upload-content/verify', [ContentController::class, "verify"]);
$app->router->get('/admin/insert-metadata', [ContentController::class, "insertMetadata"]);
$app->router->get('/admin/insert-keyword-abstract', [ContentController::class, "insertKeywordAbstract"]);
$app->router->get('/admin/submit-content', [ContentController::class, "submitContent"]);
$app->router->get('/admin/verify-submission', [ContentController::class, "verifySubmission"]);
$app->router->get('/admin/my-submissions', [ContentController::class, "mySubmissions"]);
$app->router->get('/admin/manage-content', [ContentController::class, "manageContent"]);




$app->router->get('/admin/bulk-upload', [AdministrationController::class, "bulkUpload"]);
$app->router->get('/admin/bulk-upload/review', [AdministrationController::class, "bulkUploadReview"]);
$app->router->get('/admin/publish-content', [AdministrationController::class, "publishContent"]);
$app->router->get('/admin/unpublish-content', [AdministrationController::class, "unpublishContent"]);
$app->router->get('/admin/edit-metadata', [AdministrationController::class, "editMetadata"]);
$app->router->get('/admin/remove-content', [AdministrationController::class, "removeContent"]);
$app->router->get('/admin/manage-content-collections', [AdministrationController::class, "manageContentCollections"]);
$app->router->get('/admin/content-collections', [AdministrationController::class, "contentCollections"]);
$app->router->get('/admin/admin-create-content-collection', [AdministrationController::class, "createContentCollection"]);


// Admin Dashboard => Manage Users Routes
$app->router->get('/admin/bulk-register', [AdministrationController::class, "bulkRegister"]);
$app->router->post('/admin/bulk-register', [AdministrationController::class, "bulkRegister"]);
$app->router->get('/admin/verify-new-users', [ApproveController::class, "approveNewUser"]);
$app->router->post('/admin/verify-new-users', [ApproveController::class, "approveNewUser"]);
$app->router->post('/admin/reject-new-user', [ApproveController::class, "rejectNewUser"]);
$app->router->get('/admin/users', [AdministrationController::class, "manageUsers"]);


// Still Implementing
$app->router->get('/admin/create-user-group', [UsergroupController::class, "createUserGroup"]);
$app->router->post('/admin/create-user-group', [UsergroupController::class, "createUserGroup"]);
$app->router->get('/admin/add-users', [UsergroupController::class, "addUsers"]);
$app->router->post('/admin/add-users', [UsergroupController::class, "pushUserToUserGroup"]);



// $app->router->post('/push-user-to-user-group', [UsergroupController::class, "pushUserToUserGroup"]);
// $app->router->post('/ajax/push-users-to-user-group', [UsergroupController::class, "pushUsersToUserGroup"]);
$app->router->get('/admin/manage-usergroup', [UsergroupController::class, "manageUserGroup"]);
// $app->router->post('/admin/manage-usergroup', [UsergroupController::class, "requestApproval"]);
$app->router->post('/admin/remove-user-group', [UsergroupController::class, "removeGroup"]);



$app->router->post('/usergroup/remove-user', [UsergroupController::class, "removeUser"]);



$app->router->get('/admin/manage-usergroups', [UsergroupController::class, "manageAllUserGroups"]);

$app->router->post('/admin/request-ug-approval', [UsergroupController::class, "requestApproval"]);



// $app->router->post('/ajax/usergroup/bulk-select', [UsergroupController::class, "BulkSelectAndBulkRemoveUser"]);









// User groups
$app->router->get('/admin/create-custom-user-group', [UsergroupController::class, "createCustomUserGroup"]);
$app->router->post('/admin/create-custom-user-group', [UsergroupController::class, "createCustomUserGroup"]);
$app->router->get('/admin/custom-usergroup/add-users', [UsergroupController::class, "addUsersToCustomUserGroup"]);
$app->router->post('/push-user-to-custom-user-group', [UsergroupController::class, "pushUserToCustomUserGroup"]);
$app->router->get('/admin/manage-custom-usergroup', [UsergroupController::class, "manageCustomUserGroup"]);
$app->router->post('/admin/custom-usergroup/request-approval', [UsergroupController::class, "requestApprovalForCustomUserGroup"]);


$app->router->get('/admin/my-usergroups', [UsergroupController::class, "manageMyUsergroups"]);
$app->router->get('/admin/user-groups', [UsergroupController::class, "getAllLiveUsergroups"]);









// $app->router->post('/admin/create-user-group', [AdministrationController::class, "createUserGroup"]);
// $app->router->get('/admin/create-user-group/add-users', [AdministrationController::class, "addUsersToUserGroup"]);
// $app->router->post('/ajax/push-users-to-user-group', [AdministrationController::class, "pushUsersToUserGroup"]);
// $app->router->post('/admin/create-user-group/review', [AdministrationController::class, "reviewUserGroup"]);
// $app->router->get('/admin/manage-user-groups', [AdministrationController::class, "manageUserGroup"]);
// $app->router->get('/admin/manage-my-user-groups', [AdministrationController::class, "manageMyUserGroups"]);
// $app->router->get('/admin/add-users', [AdministrationController::class, "addUsersToUserGroup"]);


$app->router->get('/admin/approve-content-collections', [AdministrationController::class, "approveContentGroup"]);
$app->router->get('/admin/approve-user-groups', [UsergroupController::class, "approveUserGroup"]);
$app->router->get('/admin/approve-submissions', [AdministrationController::class, "approveSubmissions"]);


$app->router->post('/admin/reject-user-group', [UsergroupController::class, "rejectUserGroup"]);





$app->router->post('/admin/approve-ug-request', [UsergroupController::class, "approveUGRequest"]);
$app->router->get('/ajax/open-notifications', [SiteController::class, "openNotification"]);






$app->router->get('/admin/dashboard/view-reports', [AdministrationController::class, "viewReports"]);

$app->router->get('/test', [DummyController::class, "test"]);








// Permission
$app->router->get('/admin/set-access-permission/collections', [PermissionsController::class, "browsePermissions"]);
$app->router->post('/admin/set-access-permission/collections', [PermissionsController::class, "browseUsergroup"]);







































// $app->router->post('/manage/community', [CommunitiesController::class, "update"]);


// $app->router->post('/communities', [CommunitiesController::class, "createNewCommunity"]);




$app->run();
