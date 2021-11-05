<?php

namespace app\core;

use app\core\middlewares\BaseMiddleware;

class Controller
{
    protected array $middlewares = [];
    public string $action = '';


    public const BREADCRUM_DASHBOARD = ['name' => 'Dashboard', 'link' => '/admin/dashboard'];

    public const BREADCRUM_MANAGE_CONTENT = ['name' => 'Manage content', 'link' => '/admin/dashboard/manage-content'];
    public const BREADCRUM_MANAGE_USERS = ['name' => 'Manage users', 'link' => '/admin/dashboard/manage-users'];
    public const BREADCRUM_MANAGE_REPORTS = ['name' => 'Manage reports', 'link' => '/admin/dashboard/view-reports'];
    public const BREADCRUM_MANAGE_APPROVALS = ['name' => 'Manage approvals', 'link' => '/admin/dashboard/manage-approvals'];

    // Manage Users Dashboard
    public const BREADCRUM_BULK_REGISTER = ['name' => 'Bulk register', 'link' => '/admin/bulk-register'];
    public const BREADCRUM_APPROVE_NEW_USERS = ['name' => 'Approve new users', 'link' => '/admin/verify-new-users'];
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
    public const BREADCRUM_REMOVE_CONTENT = ['name' => 'Delete content', 'link' => '/admin/remove-content'];
    public const BREADCRUM_CREATE_SUB_COMMUNITY = ['name' => 'Create sub community', 'link' => ''];
    public const BREADCRUM_CREATE_COLLECTION = ['name' => 'Create collection', 'link' => ''];
    public const BREADCRUM_EDIT_COMMUNITY = ['name' => 'Edit community', 'link' => ''];
    public const BREADCRUM_EDIT_TOP_LEVEL_COMMUNITY = ['name' => 'Edit top level community', 'link' => ''];


    public const BREADCRUM_ADD_USERGROUP_USERS = ['name' => 'Add users', 'link' => ''];
    public const BREADCRUM_MANAGE_USERGROUP_USERS = ['name' => 'Manage users', 'link' => ''];








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
