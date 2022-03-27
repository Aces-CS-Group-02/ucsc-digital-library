<?php

namespace app\core;

use app\core\middlewares\BaseMiddleware;

class Controller
{
    protected array $middlewares = [];
    public string $action = '';

    public const BREADCRUM_HOME = ['name' => 'home', 'link' => '/'];


    public const BREADCRUM_DASHBOARD = ['name' => 'Dashboard', 'link' => '/admin/dashboard'];

    public const BREADCRUM_MANAGE_CONTENT = ['name' => 'Manage content', 'link' => '/admin/dashboard/manage-content'];
    public const BREADCRUM_MANAGE_USERS = ['name' => 'Manage users', 'link' => '/admin/dashboard/manage-users'];
    public const BREADCRUM_MANAGE_REPORTS = ['name' => 'Manage reports', 'link' => '/admin/dashboard/view-reports'];
    public const BREADCRUM_MANAGE_APPROVALS = ['name' => 'Manage approvals', 'link' => '/admin/dashboard/manage-approvals'];

    // Manage Users Dashboard
    public const BREADCRUM_BULK_REGISTER = ['name' => 'Bulk register', 'link' => '/admin/bulk-register'];
    public const BREADCRUM_APPROVE_NEW_USERS = ['name' => 'Approve new users', 'link' => '/admin/verify-new-users'];
    public const BREADCRUM_APPROVE_NEW_USER = ['name' => 'Approve new user', 'link' => '/admin/info-verify-new-users'];
    public const BREADCRUM_UPDATE_USERS = ['name' => 'Users', 'link' => '/admin/users'];
    public const BREADCRUM_DELETE_USERS = ['name' => 'Users', 'link' => '/admin/users'];
    public const BREADCRUM_CREATE_USER_GROUPS = ['name' => 'Create user group', 'link' => '/admin/create-user-group'];
    public const BREADCRUM_UPDATE_USER_GROUPS = ['name' => 'Update user group', 'link' => ''];
    public const BREADCRUM_DELETE_USER_GROUPS = ['name' => 'Delete user group', 'link' => ''];
    public const BREADCRUM_MANAGE_LIA = ['name' => 'Manage Library information assistant', 'link' => '/admin/manage-library-information-assistant'];


    public const BREADCRUM_CREATE_LIA = ['name' => 'Create Library information assistant', 'link' => '/admin/create-library-information-assistant'];


    public const BREADCRUM_MANAGE_COMMUNITIES_N_COLLECTIONS = ['name' => 'Manage communities & collections', 'link' => '/admin/manage-communities'];
    public const BREADCRUM_CREATE_TOP_LEVEL_COMMUNITY = ['name' => 'Create Top level community', 'link' => '/admin/create-top-level-community'];
    public const BREADCRUM_UPLOAD_CONTENT = ['name' => 'Upload content', 'link' => '/admin/upload-content'];
    public const BREADCRUM_BULK_UPLOAD = ['name' => 'Bulk upload', 'link' => '/admin/bulk-upload'];
    public const BREADCRUM_PUBLISH_CONTENT = ['name' => 'Publish content', 'link' => '/admin/publish-content'];
    public const BREADCRUM_UNPUBLISH_CONTENT = ['name' => 'Unpublish content', 'link' => '/admin/unpublish-content'];
    public const BREADCRUM_PUBLISH_CONTENT_VIEW = ['name' => 'Published content view', 'link' => ''];
    public const BREADCRUM_UNPUBLISH_CONTENT_VIEW = ['name' => 'Unpublished content view', 'link' => ''];
    public const BREADCRUM_REMOVE_CONTENT = ['name' => 'Delete content', 'link' => '/admin/remove-content'];
    public const BREADCRUM_CREATE_SUB_COMMUNITY = ['name' => 'Create sub community', 'link' => ''];
    public const BREADCRUM_CREATE_COLLECTION = ['name' => 'Create collection', 'link' => ''];
    public const BREADCRUM_IMPORT_COLLECTION = ['name' => 'Import Collection', 'link' => ''];
    public const BREADCRUM_EDIT_COMMUNITY = ['name' => 'Edit community', 'link' => ''];
    public const BREADCRUM_EDIT_TOP_LEVEL_COMMUNITY = ['name' => 'Edit top level community', 'link' => ''];


    public const BREADCRUM_ADD_USERGROUP_USERS = ['name' => 'Add users', 'link' => ''];
    public const BREADCRUM_MANAGE_USERGROUP_USERS = ['name' => 'Manage users', 'link' => ''];
    public const BREADCRUM_MANAGE_USERGROUPS = ['name' => 'Manage usergroups', 'link' => '/admin/manage-usergroups'];


    public const BREADCRUM_BULK_UPLOAD_REVIEW = ['name' => 'Review', 'link' => '/admin/bulk-upload/review'];
    public const BREADCRUM_MANAGE_CONTENTS = ['name' => 'Manage contents', 'link' => '/admin/manage-content'];
    public const BREADCRUM_MANAGE_CONTENTS_VIEW = ['name' => 'Manage contents view', 'link' => '/admin/manage-content/view'];
    public const BREADCRUM_MY_SUBMISSIONS_VIEW = ['name' => 'My submissions view', 'link' => '/admin/my-submissions/view'];
    public const BREADCRUM_MY_SUBMISSIONS = ['name' => 'My submissions', 'link' => '/admin/my-submissions'];
    public const BREADCRUM_VIEW_ALL_USER_GROUPS = ['name' => 'View all usergroups', 'link' => '/admin/user-groups'];


    public const BREADCRUM_MANAGE_CONTENT_COLLECTIONS = ['name' => 'Manage content collections', 'link' => '/admin/manage-content-collections'];
    public const BREADCRUM_CREATE_CONTENT_COLLECTION = ['name' => 'Create content collection', 'link' => '/admin/admin-create-content-collection'];
    public const BREADCRUM_CONTENT_COLLECTIONS = ['name' => 'Content collections', 'link' => '/admin/content-collections'];

    public const BREADCRUM_APPROVE_CONTENT_COLLECTIONS = ['name' => 'Approve content collections', 'link' => '/admin/approve-content-collections'];


    public const BREADCRUM_VIEW_REPORTS = ['name' => 'View reports', 'link' => '/admin/dashboard/view-reports'];
    public const BREADCRUM_USER_APPROVALS_REPORT = ['name' => 'User approvals report', 'link' => '/admin/user-approvals-report'];
    public const BREADCRUM_USERS_LOGIN_REPORT = ['name' => 'Users\' login report', 'link' => '/admin/users-login-report'];
    public const CITATION_HISTORY_REPORT = ['name' => 'Citation history report', 'link' => '/admin/citation-history-report'];

    public const BREADCRUM_APPROVE_SUBMISSIONS = ['name' => 'Approve submissions', 'link' => '/admin/approve-submissions'];

    public const BREADCRUM_APPROVE_USER_GROUPS = ['name' => 'Approve user groups', 'link' => '/admin/approve-user-groups'];

    public const BREADCRUM_REVIEW_LEND_REQUESTS = ['name' => "Review lend requests", 'link' => '/admin/review-lend-requests'];
    public const BREADCRUM_APPROVE_ACCESS = ['name' => 'Approve access', 'link' => '/admin/dashboard/manage-approvals/approve-access'];
    public const BREADCRUM_REVIEW_COLLECTION_PERMISSION = ['name' => 'Review collection permission', 'link' => '/admin/approve-access-permission/collections'];
    public const BREADCRUM_REVIEW_CONTENT_COLLECTION_PERMISSION = ['name' => 'Review content collection permission', 'link' => '/admin/approve-access-permission/content-collections'];

    public const BREADCRUM_COMMUNITY_COLLECTION_ACCESS_PERMISSION = ['name' => 'Set collection permssion', 'link' => '/admin/set-access-permission'];

    public const BREADCRUM_COMMUNITY_LIST = ['name' => 'Top level communities', 'link' => '/community-list'];












    public function render($view, $params = [])
    {
        return Application::$app->router->renderView($view, $params);
    }

    public function registerMiddleware(BaseMiddleware $middleware)
    {
        $this->middlewares[] = $middleware;
    }

    public function getMiddlewares(): array
    {
        return $this->middlewares;
    }
}
