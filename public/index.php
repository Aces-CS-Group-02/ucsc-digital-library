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
use app\controllers\SearchController;
use app\core\Application;
use app\core\Database;
use app\models\User;
use app\controllers\ContentCollectionController;
use app\models\Content;
use app\controllers\ExportController;
use app\models\Collection;
use app\models\ContentCollectionContent;
use app\controllers\ImportController;
use app\controllers\DemoController;

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
$app->router->get('/advanced-search', [SearchController::class, "advancedSearch"]);
$app->router->get('/search-result', [SearchController::class, "searchResult"]);
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
$app->router->get('/admin/edit-collection', [CollectionController::class, "editCollection"]);
$app->router->post('/admin/edit-collection', [CollectionController::class, "editCollection"]);


//User routes
$app->router->get('/profile', [UserController::class, "profile"]);
$app->router->get('/profile/edit', [UserController::class, "editProfile"]);
$app->router->get('/profile/create-user-collection', [UserController::class, "userCollection"]);
$app->router->post('/profile/create-user-collection', [UserController::class, "createNewUserCollection"]);
$app->router->get('/profile/my-collections', [UserController::class, "userCollections"]);
// $app->router->post('/profile/my-collections', [UserController::class, "userCollections"]);
$app->router->get('/profile/manage-collection-view', [UserController::class, "manageCollectionTest"]);
$app->router->get('/profile/manage-collection', [UserController::class, "manageCollection"]);
$app->router->get('/profile/edit-collection', [UserController::class, "editCollection"]);
$app->router->post('/profile/edit-collection', [UserController::class, "saveEditCollection"]);
$app->router->get('/content/view', [UserController::class, "viewPdfViewer"]);
// $app->router->post('/content/view', [UserController::class, "viewPdfViewer"]);
$app->router->get('/profile/video-player', [UserController::class, "videoPlayer"]);
$app->router->get('/suggest-content', [UserController::class, "suggestContent"]);
$app->router->post('/suggest-content', [UserController::class, "createContentSuggestion"]);
$app->router->get('/profile/content-notes-view', [UserController::class, "viewContentNotes"]);
$app->router->get('/profile/recent-readings-view', [UserController::class, "viewRecentReadings"]);

//here
$app->router->get('/ajax/get-user-collections', [UserController::class, "getUserCollections"]);
$app->router->post('/ajax/user-bookmarks', [UserController::class, "addContentBookmark"]);
$app->router->post('/ajax/get-user-bookmarks', [UserController::class, "getContentBookmark"]);
$app->router->post('/ajax/delete-user-bookmarks', [UserController::class, "deleteContentBookmark"]);
$app->router->post('/ajax/get-content-share-link', [ContentController::class, "getContentShareLink"]);
$app->router->post('/ajax/get-citation', [ContentController::class, "getCitation"]);
$app->router->post('/ajax/get-user-notes', [UserController::class, "saveContentNote"]);
$app->router->get('/ajax/get-user-notes', [UserController::class, "getContentNote"]);
$app->router->post('/ajax/delete-user-notes', [UserController::class, "deleteContentNote"]);
$app->router->get('/ajax/get-user-collection-content', [UserController::class, "getCollectionContent"]);
$app->router->post('/ajax/add-content-to-user-collection', [UserController::class, "addContentToCollection"]);
$app->router->post('/ajax/remove-content-from-user-collection', [UserController::class, "removeContentFromCollection"]);
$app->router->post('/ajax/remove-user-collection', [UserController::class, "removeUserCollection"]);
$app->router->post('/ajax/create-and-add-to-collection', [UserController::class, "createUserCollectionAndAddContent"]);


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
$app->router->get('/admin/dashboard/view-reports', [AdministrationController::class, "viewReports"]);
$app->router->get('/admin/dashboard/manage-approvals/approve-access', [AdministrationController::class, "manageAccess"]);




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
// $app->router->get('/admin/publish-content', [AdministrationController::class, "publishContent"]);
// $app->router->get('/admin/unpublish-content', [AdministrationController::class, "unpublishContent"]);
$app->router->get('/admin/edit-metadata', [AdministrationController::class, "editMetadata"]);
$app->router->get('/admin/remove-content', [AdministrationController::class, "removeContent"]);
$app->router->get('/admin/content-collections', [AdministrationController::class, "contentCollections"]);
$app->router->get('/admin/admin-create-content-collection', [AdministrationController::class, "createContentCollection"]);
$app->router->get('/admin/export/collection', [ExportController::class, "exportCollection"]);
$app->router->get('/admin/import/collection', [ImportController::class, "importCollection"]);
$app->router->post('/admin/import/collection', [ImportController::class, "importCollection"]);


// Admin Dashboard => Manage Users Routes
$app->router->get('/admin/bulk-register', [AdministrationController::class, "bulkRegister"]);
$app->router->post('/admin/bulk-register', [AdministrationController::class, "bulkRegister"]);
$app->router->post('/admin/bulk-register/register-selected-users', [AdministrationController::class, "registerSelectedUsers"]);
// $app->router->get('/admin/verify-new-users', [ApproveController::class, "approveNewUser"]);
$app->router->get('/admin/verify-new-users', [ApproveController::class, "allApproveNewUser"]);
$app->router->post('/admin/verify-new-users', [ApproveController::class, "approveNewUser"]);
$app->router->post('/admin/reject-new-user', [ApproveController::class, "rejectNewUser"]);
$app->router->get('/admin/users', [AdministrationController::class, "manageUsers"]);

// Admin Dashboard => Manage Reports Routes
$app->router->get('/admin/dashboard/view-reports', [AdministrationController::class, "viewReports"]);
$app->router->get('/admin/user-approvals-report', [AdministrationController::class, "viewApprovalsReport"]);
$app->router->get('/admin/users-login-report', [AdministrationController::class, "viewLoginReport"]);
$app->router->get('/admin/citation-history-report', [AdministrationController::class, "viewCitationHistoryReport"]);


// Still Implementing
$app->router->get('/admin/create-user-group', [UsergroupController::class, "createUserGroup"]);
$app->router->post('/admin/create-user-group', [UsergroupController::class, "createUserGroup"]);
$app->router->get('/admin/add-users', [UsergroupController::class, "addUsers"]);
$app->router->post('/admin/add-users', [UsergroupController::class, "pushUserToUserGroup"]);
$app->router->get('/admin/approve-new-user/view', [ApproveController::class, "viewNewUserDetails"]);
$app->router->get('/help', [SiteController::class, "help"]);
$app->router->post('/admin/users/delete', [UserController::class, "deleteUsers"]);
$app->router->get('/admin/publish-content', [ContentController::class, "loadPublishContentPage"]);
$app->router->get('/admin/unpublish-content', [ContentController::class, "loadUnpublishContentPage"]);
$app->router->get('/admin/publish-content/view', [ContentController::class, "viewPublishContentDetails"]);
$app->router->get('/admin/unpublish-content/view', [ContentController::class, "viewUnpublishContentDetails"]);
$app->router->post('/admin/publish-content/publish', [ContentController::class, "publishingContent"]);
$app->router->post('/admin/unpublish-content/unpublish', [ContentController::class, "unpublishingContent"]);
$app->router->get('/admin/manage-content', [ContentController::class, "manageContent"]);
$app->router->post('/admin/manage-content', [ContentController::class, "manageContent"]);
$app->router->get('/admin/manage-content/view', [ContentController::class, "viewContent"]);
$app->router->get('/admin/my-submissions/view', [ContentController::class, "viewMyContent"]);
$app->router->post('/admin/manage-content/delete', [ContentController::class, "deleteContent"]);
$app->router->post('/admin/my-submissions/delete', [ContentController::class, "deleteMyContent"]);





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
$app->router->post('/admin/approve-submissions', [AdministrationController::class, "approveSubmissions"]);
$app->router->post('/admin/reject-submissions', [AdministrationController::class, "rejectSubmissions"]);


$app->router->post('/admin/reject-user-group', [UsergroupController::class, "rejectUserGroup"]);





$app->router->post('/admin/approve-ug-request', [UsergroupController::class, "approveUGRequest"]);
$app->router->get('/ajax/open-notifications', [SiteController::class, "openNotification"]);







$app->router->get('/test', [DummyController::class, "test"]);












//testing
$app->router->get('/adv-search', [SearchController::class, "advancedS"]);




// Content Collection
$app->router->get('/admin/create-content-collection', [ContentCollectionController::class, "createContentCollection"]);
$app->router->post('/admin/create-content-collection', [ContentCollectionController::class, "createContentCollection"]);
$app->router->get('/admin/add-content', [ContentCollectionController::class, "addContents"]);
$app->router->post('/admin/add-content', [ContentCollectionController::class, "pushContentToContentCollection"]);
$app->router->get('/admin/manage-content-collection', [ContentCollectionController::class, "manageContentCollection"]);
$app->router->post('/content-collection/remove-content', [ContentCollectionController::class, "removeContent"]);
$app->router->post('/admin/request-content-collection-approval', [ContentCollectionController::class, "requestApproval"]);
$app->router->get('/admin/manage-content-collections', [ContentCollectionController::class, "manageAllUserGroups"]);
$app->router->post('/admin/remove-content-collection', [ContentCollectionController::class, "removeContentCollection"]);
$app->router->get('/admin/approve-content-collections', [ContentCollectionController::class, "approveContentCollections"]);
$app->router->post('/admin/approve-cc-request', [ContentCollectionController::class, "approveCCRequest"]);
$app->router->post('/admin/reject-content-collection', [ContentCollectionController::class, "rejectContentCollection"]);



// Collection Permission
$app->router->get('/admin/set-access-permission', [PermissionsController::class, "browsePermissions"]);
$app->router->get('/admin/set-access-permission/collections', [PermissionsController::class, "browseUsergroup"]);
$app->router->get('/admin/set-access-permission/collections/select-permission', [PermissionsController::class, "setPermissionToCollection"]);
$app->router->post('/admin/set-access-permission/collections/select-permission', [PermissionsController::class, "setPermissionToCollection"]);
$app->router->get('/admin/set-access-permission/status-success', [PermissionsController::class, "statusSuccess"]);
$app->router->get('/admin/set-access-permission/status-failed', [PermissionsController::class, "statusSuccess"]);
$app->router->get('/admin/view-collection-permission', [PermissionsController::class, "viewAccessPermissionOnCollections"]);
$app->router->post('/admin/remove-permission/collection', [PermissionsController::class, "removePermissionOnCollections"]);


// Content Collection Permission
$app->router->get('/admin/set-content-collection-access-permission', [PermissionsController::class, "browseContentCollectionPermissions"]);
$app->router->get('/admin/set-content-collection-access-permission/content-collection', [PermissionsController::class, "browseUsergroupForContentCollection"]);
$app->router->get('/admin/set-content-collection-access-permission/select-permission', [PermissionsController::class, "setPermissionToContentCollection"]);
$app->router->post('/admin/set-content-collection-access-permission/select-permission', [PermissionsController::class, "setPermissionToContentCollection"]);
$app->router->get('/admin/view-content-collection-permission', [PermissionsController::class, "viewContentCollectionPermission"]);
$app->router->post('/admin/remove-content-collection-access-permission', [PermissionsController::class, "removeConentCollectionAccessPermission"]);



// $app->router->post('/admin/set-access-permission/collections/select-permission', [PermissionsController::class, "setPermissionToCollection"]);
// $app->router->get('/admin/set-access-permission/status-success', [PermissionsController::class, "statusSuccess"]);
// $app->router->get('/admin/set-access-permission/status-failed', [PermissionsController::class, "statusSuccess"]);
// $app->router->get('/admin/view-access-permission', [PermissionsController::class, "viewAccessPermissionOnCollections"]);
// $app->router->post('/remove-permission/collection', [PermissionsController::class, "removePermissionOnCollections"]);




// Approve, Reject Content Collection Access Permission
$app->router->get('/admin/approve-access-permission/content-collections', [PermissionsController::class, "approveContentCollectionAccessPermission"]);
$app->router->post('/admin/approve-content-collection-access-permission', [PermissionsController::class, "approveAccessPermission"]);
$app->router->post('/admin/reject-content-collection-access-permission', [PermissionsController::class, "rejectAccessPermission"]);


// Approve, Reject Collection Access Permission
$app->router->get('/admin/approve-access-permission/collections', [PermissionsController::class, "reviewCollectionAccessPermission"]);
$app->router->post('/admin/approve-collection-access-permission', [PermissionsController::class, "approveCollectionAccessPermission"]);
$app->router->post('/admin/reject-collection-access-permission', [PermissionsController::class, "rejectCollectionAccessPermission"]);



// $app->router->post('/admin/add-users', [UsergroupController::class, "pushUserToUserGroup"]);


$app->router->get('/content', [ContentController::class, 'viewContentAbstract']);





$app->router->get('/community-list', [SiteController::class, 'browseByCommunitiesAndCollections']);
$app->router->get('/browse/community', [SiteController::class, 'browseByCommunity']);
$app->router->get('/browse/collection', [SiteController::class, 'browseByCollection']);



// $app->router->post('/admin/set-access-permission/collections/set-permission', [PermissionsController::class, "setPermissionToCollection"]);


$app->router->post('/admin/delete-collection', [CollectionController::class, 'deleteCollection']);
$app->router->post('/admin/delete-community', [CommunitiesController::class, 'remove']);

$app->router->post('/ajax/get-access-to-content', [SiteController::class, 'getAccess']);
$app->router->post('/ajax/get-access-to-content/make-request', [SiteController::class, 'getAccessRequest']);

$app->router->get('/admin/review-lend-requests', [SiteController::class, 'reviewLendRequests']);

$app->router->post('/admin/process-lend-request/approve', [SiteController::class, 'approveLendRequest']);
$app->router->post('/admin/process-lend-request/reject', [SiteController::class, 'rejectLendRequest']);

$app->router->get('/test', [DemoController::class, 'test']);
$app->router->get('/test/view', [DemoController::class, 'viewPdfViewer']);


$app->router->get('/test', [DemoController::class, 'test']);
$app->router->get('/test/view', [DemoController::class, 'viewPdfViewer']);





$app->router->post('/admin/testing', [DummyController::class, "test"]);





























// $app->router->post('/manage/community', [CommunitiesController::class, "update"]);


// $app->router->post('/communities', [CommunitiesController::class, "createNewCommunity"]);




$app->run();
