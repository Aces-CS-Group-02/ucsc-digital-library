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
    <link rel="stylesheet" href="/css/local-styles/create-top-level-communities.css">




    <title>Create Community</title>
</head>

<body>

    <!-- NAVIGATION BAR -->



    <?php
    include_once dirname(__DIR__) . '/components/nav.php';
    ?>

    <!-- Main Content Container -->

    <div id="update-user-main-content">
        <div class="page-header-container">
            <p id="page-header-title">Create Community</p>
            <?php include_once dirname(__DIR__) . '/components/breadcrum.php'; ?>

        </div>

        <div class="wrapper">

            <!-- Flash Message -->
            <?php

            use app\core\Application;

            if (Application::$app->session->getFlashMessage('success-community-creation')) { ?>


                <div class="alert alert-success" id="flash-msg-alert">
                    <strong>Success!</strong>

                    <?php echo Application::$app->session->getFlashMessage('success-community-creation'); ?>

                    <button class="close" type="button" id="flash-msg-remove">
                        <span class="font-weight-light"></span>
                        <i class="fas fa-times icon-sucess" style="font-size: 0.73em"></i>
                    </button>
                </div>


            <?php } ?>

            <?php


            if (Application::$app->session->getFlashMessage('error')) { ?>


                <div class="alert alert-success" id="flash-msg-alert">
                    <strong>Success!</strong>

                    <?php echo Application::$app->session->getFlashMessage('error'); ?>

                    <button class="close" type="button" id="flash-msg-remove">
                        <span class="font-weight-light"></span>
                        <i class="fas fa-times icon-sucess" style="font-size: 0.73em"></i>
                    </button>
                </div>


            <?php } ?>





            <form id="create-community-form" action="" method="POST">
                <div class="input-row-group">

                    <?php {
                        $attr_name = 'name';
                        $errors_on_name = false;
                        if (isset($params['model']) && $params['model']->hasErrors($attr_name)) {
                            $errors_on_name = true;
                        }
                    ?>

                        <div class="input-group">
                            <label class="labelPlace <?php if ($errors_on_name) {
                                                            echo "danger-text";
                                                        } ?>" for="Name">Community Name</label>
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

                    <?php } ?>

                    <div class="input-group">
                        <label class="labelPlace" for="description-text-area">Community description</label>
                        <textarea class="form-control" id="description-text-area" type="text" name="description" value="<?php echo $params['model']->description ?? "" ?>"></textarea>


                    </div>

                    <button class="btn btn-primary" id="create-community-btn" <?php if (isset($params['parent_community_id'])) {
                                                                                    echo 'name="parent_community_id"';
                                                                                } ?> "
                                                                                
                                                                                <?php if (isset($params['parent_community_id'])) {
                                                                                    echo 'value="' . $params['parent_community_id'];
                                                                                }  ?>">Create</button>
                </div>
            </form>





        </div>
    </div>
    <?php
    include_once dirname(__DIR__) . '/components/footer.php';
    ?>

    <script src="/javascript/nav.js"></script>
    <script src="/javascript/profile.js"></script>

</body>

</html>