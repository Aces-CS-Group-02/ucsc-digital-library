<?php
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
    <link rel="stylesheet" href="/css/local-styles/admin-dashboard.css">

    <title>Document</title>
</head>

<body>

    <?php
    include_once dirname(__DIR__) . '/components/nav.php';
    ?>

    <div class="admin-dashboard-main-content">
        <div class="admin-dashboard-text">
            Admin Dashboard
        </div>


        <div class="grid-container">
            <div class="card-container">
                <a href="/admin/dashboard/manage-content" class="card box-shadow-1">
                    <div class="card-icon">
                        <img src="/assets\admin-dashboard\briefcase.svg" alt=" briefcase-image">
                    </div>
                    <div class="card-content ">Manage Content</div>
                </a>

            </div>
            <div class="card-container">
                <a href="/admin/dashboard/manage-users" class="card box-shadow-1">
                    <div class="card-icon">
                        <img src="/assets\admin-dashboard\user-settings.png" alt=" user-image">
                    </div>
                    <div class="card-content ">Manage Users</div>
                </a>

            </div>
            <div class="card-container">
                <a href="/admin/dashboard/view-reports" class="card box-shadow-1">
                    <div class="card-icon">
                        <img src="/assets\admin-dashboard\graph.png" alt=" graph-image">
                    </div>
                    <div class="card-content ">View Reports</div>
                </a>

            </div>

            <div class="card-container">
                <a href="/admin/dashboard/manage-approvals" class="card box-shadow-1">
                    <div class="card-icon">
                        <img src="/assets\admin-dashboard\checked.svg" alt=" checked-image">
                    </div>
                    <div class="card-content ">Approval</div>
                </a>

            </div>

        </div>
    </div>

    <!-- FOOTER -->

    <?php
    include_once dirname(__DIR__) . '/components/footer.php';
    ?>

    <!-- SCRIPT -->

    <script src="/javascript/nav.js"></script>

</body>

</html>