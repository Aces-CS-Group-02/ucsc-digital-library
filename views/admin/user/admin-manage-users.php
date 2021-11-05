<?php

use app\core\Application;

$isLoggedIn = true;
$userRole = "admin";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Global Styles -->
    <link rel="stylesheet" href="/css/global-styles/style.css">
    <link rel="stylesheet" href="/css/global-styles/nav.css">
    <link rel="stylesheet" href="/css/global-styles/footer.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Aces css framework -->
    <link rel="stylesheet" href="/css/aces-css-framework/style.css">

    <!-- Local Styles -->
    <link rel="stylesheet" href="/css/local-styles/admin-manage-users.css">

    <title>Document</title>
</head>

<body>

    <?php
    include_once dirname(dirname(__DIR__)) . '/components/nav.php';
    ?>
    <div class="admin-dashboard-main-content">
        <div class="admin-dashboard-text">
            <p id='page-header-title'>Manage Users</p>
            <?php include_once dirname(dirname(__DIR__)) . '/components/breadcrum.php'; ?>
        </div>


        <?php if (Application::$app->getUserRole() <= 2) { ?>
            <div class="grid-container">
                <div class="content-dashboard-text">
                    User
                </div>

                <div class="card-container">
                    <a href="/admin/bulk-register" class="card box-shadow-1">
                        <div class="card-icon">
                            <div style="position: relative;">
                                <img class="card-icon-img" src="/assets\admin-manage-users\add-user.png" alt=" bulk-register-image">
                            </div>
                        </div>
                        <div class="card-content ">Bulk Register</div>
                    </a>

                </div>

                <div class="card-container">
                    <a href="/admin/verify-new-users" class="card box-shadow-1">
                        <div class="card-icon">
                            <img class="card-icon-img" src="/assets\admin-manage-users\approve-user.png" alt=" approve-user-image">
                        </div>
                        <div class="card-content ">Approve New Users</div>
                    </a>

                </div>
                <div class="card-container">
                    <a href="/admin/users" class="card box-shadow-1">
                        <div class="card-icon">
                            <img class="card-icon-img" src="/assets\admin-manage-users\update-user.png" alt=" update-user-image">
                        </div>
                        <div class="card-content ">Manage Users </div>
                    </a>

                </div>
            </div>
        <?php } ?>


        <div class="grid-container">
            <div class="content-dashboard-text">
                User Groups
            </div>
            <div class="card-container">
                <a href="/admin/create-user-group" class="card box-shadow-1">
                    <div class="card-icon">
                        <img class="card-icon-img" src="/assets\admin-manage-users\add-user-group.png" alt=" create-group-image">
                    </div>
                    <div class="card-content ">Create User Group</div>
                </a>
            </div>
            <div class="card-container">
                <a href="/admin/manage-usergroups" class="card box-shadow-1">
                    <div class="card-icon">
                        <img class="card-icon-img" src="/assets\admin-manage-users\add-user-group.png" alt=" create-group-image">
                    </div>
                    <div class="card-content ">Manage User Groups</div>
                </a>
            </div>
            <div class="card-container">
                <a href="/admin/manage-user-groups" class="card box-shadow-1">
                    <div class="card-icon">
                        <img class="card-icon-img" src="/assets\admin-manage-users\update-user.png" alt=" update-groups-image">
                    </div>
                    <div class="card-content ">My User Groups</div>
                </a>
            </div>
        </div>

        <?php if (Application::$app->getUserRole() < 2) { ?>
            <div class="grid-container">
                <div class="content-dashboard-text">
                    Manage Library Information Assistant(LIA) Accounts
                </div>
                <div class="card-container">
                    <a href="/admin/manage-library-information-assistant" class="card box-shadow-1">
                        <div class="card-icon">
                            <img class="card-icon-img" src="/assets\admin-manage-users\add-user.png" alt=" create-LIA-image">
                        </div>
                        <div class="card-content ">Manage Library Information Assistants</div>
                    </a>
                </div>
            </div>
        <?php } ?>

    </div>


    <!-- FOOTER -->

    <?php
    include_once dirname(dirname(__DIR__)) . '/components/footer.php';
    ?>

    <!-- SCRIPT -->

    <script src="/javascript/nav.js"></script>

</body>

</html>