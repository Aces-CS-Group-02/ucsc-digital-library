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
    <link rel="stylesheet" href="/css/local-styles/admin-manage-content.css">

    <title>Document</title>
</head>

<body>

    <?php
    include_once dirname(dirname(__DIR__)) . '/components/nav.php';
    ?>
    <div class="admin-dashboard-main-content">
        <div class="admin-dashboard-text">
            <p id='page-header-title'>Manage Content</p>

            <?php include_once dirname(dirname(__DIR__)) . '/components/breadcrum.php'; ?>
        </div>


        <div class="grid-container">
            <div class="content-dashboard-text ">
                Content
            </div>
            <div class="card-container">
                <a href="/admin/upload-content" class="card box-shadow-1">
                    <div class="card-icon">
                        <img class="card-icon-img" src="/assets\admin-manage-content\document.svg" alt=" document-image">
                    </div>
                    <div class="card-content ">Upload Content</div>
                </a>
            </div>
            <?php if (Application::$app->getUserRole() <= 2) { ?>

                <div class="card-container">
                    <a href="/admin/bulk-upload" class="card box-shadow-1">
                        <div class="card-icon">
                            <img class="card-icon-img" src="/assets\admin-manage-content\bulk.png" alt=" bulk-upload-image">
                        </div>
                        <div class="card-content ">Bulk Upload</div>
                    </a>

                </div>

                <div class="card-container">
                    <a href="/admin/publish-content" class="card box-shadow-1">
                        <div class="card-icon">
                            <img class="card-icon-img" src="/assets\admin-manage-content\publish-content.png" alt=" cloud-image">
                        </div>
                        <div class="card-content ">Publish Content</div>
                    </a>

                </div>


                <div class="card-container">
                    <a href="/admin/unpublish-content" class="card box-shadow-1">
                        <div class="card-icon">
                            <img class="card-icon-img" src="/assets\admin-manage-content\unpublish-content.png" alt=" cloud-image">
                        </div>
                        <div class="card-content ">Unpublish Content</div>
                    </a>

                </div>


                <div class="card-container">
                    <a href="/admin/manage-content" class="card box-shadow-1">
                        <div class="card-icon">
                            <img class="card-icon-img" src="/assets\admin-manage-content\metadata.png" alt=" content-add/update-image">
                        </div>
                        <div class="card-content ">Manage Content</div>
                    </a>

                </div>
            <?php } ?>
            <div class="card-container">
                <a href="/admin/my-submissions" class="card box-shadow-1">
                    <div class="card-icon">
                        <img class="card-icon-img" src="/assets\admin-manage-content\my-submissions.png" alt=" content-delete-image">
                    </div>
                    <div class="card-content ">My Submissions</div>
                </a>
            </div>


        </div>

        <?php if (Application::$app->getUserRole() <= 2) { ?>

            <div class="grid-container">
                <div class="content-dashboard-text ">
                    Communities & Collections
                </div>
                <div class="card-container">
                    <a href="/admin/manage-communities" class="card box-shadow-1">
                        <div class="card-icon">
                            <img class="card-icon-img" src="/assets\admin-manage-content\manage-communities.png" alt=" cloud-image">
                        </div>
                        <div class="card-content ">Manage Communities & Collection</div>
                    </a>
                </div>
            </div>

        <?php } ?>

        <div class="grid-container">
            <div class="content-dashboard-text ">
                Content Collections
            </div>
            <div class="card-container">
                <a href="/admin/manage-content-collections" class="card box-shadow-1">
                    <div class="card-icon">
                        <img class="card-icon-img" src="/assets\admin-manage-content\manage-collections.png" alt=" cloud-image">
                    </div>
                    <div class="card-content ">Manage Content Collections</div>
                </a>
            </div>
            <div class="card-container">
                <a href="/admin/content-collections" class="card box-shadow-1">
                    <div class="card-icon">
                        <img class="card-icon-img" src="/assets\admin-manage-content\my-collections.png" alt=" cloud-image">
                    </div>
                    <div class="card-content ">My Content Collections</div>
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