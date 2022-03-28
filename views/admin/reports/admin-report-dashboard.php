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
    <link rel="stylesheet" href="/css/local-styles/admin-report-dashboard.css">

    <title>Reports</title>
</head>

<body>

    <?php
    include_once dirname(dirname(__DIR__)) . '/components/nav.php';
    ?>
    <div class="admin-dashboard-main-content">
        <div class="admin-dashboard-text">
            <p id='page-header-title'>View Reports</p>

            <?php include_once dirname(dirname(__DIR__)) . '/components/breadcrum.php'; ?>
        </div>


        <div class="grid-container">
            <div class="content-dashboard-text ">
                All Reports
            </div>
            
                <div class="card-container">
                    <a href="/admin/users-login-report" class="card box-shadow-1">
                        <div class="card-icon">
                            <img class="card-icon-img" src="\assets\admin-reports-dashboard\users.png" alt=" document-image">
                        </div>
                        <div class="card-content ">Users' Login Report</div>
                    </a>
                </div>
                <!-- <div class="card-container">
                    <a href="" class="card box-shadow-1">
                        <div class="card-icon">
                            <img class="card-icon-img" src="\assets\admin-reports-dashboard\system.png" alt=" bulk-upload-image">
                        </div>
                        <div class="card-content ">System Log Report</div>
                    </a>

                </div> -->
                <div class="card-container">
                    <a href="/admin/user-approvals-report" class="card box-shadow-1">
                        <div class="card-icon">
                            <img class="card-icon-img" src="\assets\admin-reports-dashboard\subscription-1.png" alt=" cloud-image">
                        </div>
                        <div class="card-content ">User Approvals Report</div>
                    </a>

                </div>
                <div class="card-container">
                    <a href="/admin/citation-history-report" class="card box-shadow-1">
                        <div class="card-icon">
                            <img class="card-icon-img" src="\assets\admin-reports-dashboard\citation-1.png" alt=" cloud-image">
                        </div>
                        <div class="card-content ">Citation History Report</div>
                    </a>

                </div>

                <div class="card-container">
                    <a href="/admin/suggested-content-report" class="card box-shadow-1">
                        <div class="card-icon">
                            <img class="card-icon-img" src="\assets\admin-reports-dashboard\suggestion-1.png" alt=" content-add/update-image">
                        </div>
                        <div class="card-content ">Suggested Content Report</div>
                    </a>

                </div>
        </div>

    </div>

    <!-- FOOTER -->

    <?php
    include_once dirname(dirname(__DIR__)) . '/components/footer.php';
    ?>

    <!-- SCRIPT -->

    <script src="/javascript/nav.js"></script>
</body>

</html>