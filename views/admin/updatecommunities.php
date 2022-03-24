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
    <link rel="stylesheet" href="/css/local-styles/edit-communities.css">



    <title>Update Community</title>
</head>

<body>

    <!-- NAVIGATION BAR -->

    <?php
    include_once dirname(__DIR__) . './components/nav.php';

    ?>

    <!-- Main Content Container -->

    <div id="update-user-main-content">
        <div class="page-header-container">
            <p id="page-header-title">Edit Community | <?php echo $params['communityname'] ?? "" ?></p>
            <?php include_once dirname(__DIR__) . '/components/breadcrum.php'; ?>

        </div>

        <div class="wrapper">

            <!-- Flash Message -->
            <?php

            use app\core\Application;

            if (Application::$app->session->getFlashMessage('update-success')) { ?>


                <div class="alert alert-success" id="flash-msg-alert">
                    <strong>Success!</strong>

                    <?php echo Application::$app->session->getFlashMessage('update-success'); ?>

                    <button class="close" type="button" id="flash-msg-remove">
                        <span class="font-weight-light"></span>
                        <i class="fas fa-times icon-sucess" style="font-size: 0.73em"></i>
                    </button>
                </div>


            <?php } ?>

            <!-- Flash Message -->
            <?php


            if (Application::$app->session->getFlashMessage('update-fail')) { ?>


                <div class="alert alert-success" id="flash-msg-alert">
                    <strong>Fail!</strong>

                    <?php echo Application::$app->session->getFlashMessage('update-fail'); ?>

                    <button class="close" type="button" id="flash-msg-remove">
                        <span class="font-weight-light"></span>
                        <i class="fas fa-times icon-sucess" style="font-size: 0.73em"></i>
                    </button>
                </div>


            <?php } ?>



            <?php
            $attr_name = 'name';
            $errors_on_name = false;
            if (isset($params['model']) && $params['model']->hasErrors($attr_name)) {
                $errors_on_name = true;
            }
            ?>

            <form action="" method="POST" id="edit-community-form">
                <input type="hidden" name="redirect" value="<?= $params['redirect'] ?>" />
                <div class="input-group">

                    <label class="labelPlace <?php if ($errors_on_name) {
                                                    echo "danger-text";
                                                } ?>" for="Name">Community name</label>
                    <input class="form-control <?php if ($errors_on_name) {
                                                    echo "danger-border";
                                                } ?>" id="Name" type="text" name="name" value="<?php echo $params['model']->name ?? "" ?>" />

                    <?php
                    if ($errors_on_name) {
                        foreach ($params['model']->errors[$attr_name] as $error) { ?>
                            <div class="validation-error">
                                <i class="fas fa-exclamation-circle"></i>
                                <p><?php echo $error ?></p>
                            </div>
                    <?php }
                    };
                    ?>


                </div>
                <div class="input-group">
                    <label class="labelPlace" for="description-text-area">Community description</label>
                    <textarea class="form-control" id="description-text-area" type="text" name="description" value=""><?php echo $params['model']->description ?? "" ?></textarea>


                </div>

                <button class="btn btn-primary" id="update-community-btn" name="community_id" value="<?php echo $params['model']->community_id ?>">Update</button>

            </form>


            <!-- Form goes here -->

        </div>
    </div>
    <?php
    include_once dirname(__DIR__) . '/components/footer.php';
    ?>
    <script src="/javascript/nav.js"></script>
    <script src="/javascript/profile.js"></script>
    <script>
        (() => {
            const flashMessage = document.getElementById('flash-msg-alert');
            const flashMessageAlertDeteteBtn = document.getElementById('flash-msg-remove');


            if (flashMessageAlertDeteteBtn) {
                flashMessageAlertDeteteBtn.onclick = function() {
                    flashMessage.remove();
                }
            }



        })();
    </Script>

</body>

</html>