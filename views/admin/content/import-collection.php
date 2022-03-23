<?php
$isLoggedIn = true;
$userRole = "student";
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
    <link rel="stylesheet" href="/css/local-styles/admin-bulk-upload.css">



    <title>Import Collection</title>
</head>

<body>

    <!-- NAVIGATION BAR -->

    <?php
    include_once dirname(dirname(__DIR__)) . '/components/nav.php';
    ?>

    <!-- Flash Message -->
    <?php

    use app\core\Application;

    if (Application::$app->session->getFlashMessage('success')) { ?>


        <div class="alert alert-success" id="flash-msg-alert">
            <strong>Success!</strong>

            <?php echo Application::$app->session->getFlashMessage('success'); ?>

            <button class="close" type="button" id="flash-msg-remove">
                <span class="font-weight-light"></span>
                <i class="fas fa-times icon-success" style="font-size: 0.73em"></i>
            </button>
        </div>


    <?php } ?>

    <?php


    if (Application::$app->session->getFlashMessage('error')) { ?>


        <div class="alert alert-danger" id="flash-msg-alert">
            <strong>Success!</strong>

            <?php echo Application::$app->session->getFlashMessage('error'); ?>

            <button class="close" type="button" id="flash-msg-remove">
                <span class="font-weight-light"></span>
                <i class="fas fa-times icon-danger" style="font-size: 0.73em"></i>
            </button>
        </div>


    <?php } ?>

    <!-- Main Content Container -->
    <div class="admin-dashboard-main-content">
        <div class="admin-dashboard-text">
            <p id="page-header-title">Import Collection</p>
            <?php include_once dirname(dirname(__DIR__)) . '/components/breadcrum.php'; ?>
        </div>
        <div class="form-container form-container-override">
            <form class="form-feature" action="" method="POST" enctype="multipart/form-data">
                <div class="input-container">
                    <div class="input-group">
                        <label class="labelPlace" for="">Upload exported zip file</label>
                        <div class="custom-file custom-file-override">
                            <input class="custom-file-input" name="collection-zip-file" id="customFile" type="file" accept=“zip/*” />
                            <label class="custom-file-label" for="customFile"> </label>
                        </div>
                    </div>
                    <div class="input-group">

                        <button class="btn btn-primary mr-1" type="submit">Next</button>

                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- FOOTER -->

    <?php
    include_once dirname(dirname(__DIR__)) . '/components/footer.php';
    ?>
    <script src="./javascript/nav.js"></script>
</body>

</html>