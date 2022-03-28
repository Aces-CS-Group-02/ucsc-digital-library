<?php

use app\core\Application;

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
    <link rel="stylesheet" href="/css/global-styles/paginate.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Aces css framework -->
    <link rel="stylesheet" href="/css/aces-css-framework/style.css">

    <!-- Local Styles -->
    <link rel="stylesheet" href="/css/local-styles/set-access-permission.css">




    <title>Manage Communities</title>
</head>

<body>

    <!-- NAVIGATION BAR -->



    <?php
    include_once dirname(__DIR__) . '/components/nav.php';
    ?>
    <!-- Main Content Container -->

    <div id="update-user-main-content">
        <div class="page-header-container">
            <p id='page-header-title'>Set Access permission</p>


            <?php include_once dirname(__DIR__) . '/components/breadcrum.php' ?>
        </div>

        <div class=" wrapper">

            <!-- Flash Message Succss -->
            <?php
            if (Application::$app->session->getFlashMessage('success')) { ?>
                <div class="alert alert-success" id="flash-msg-alert">
                    <strong>Success!</strong>
                    <?php echo Application::$app->session->getFlashMessage('success'); ?>
                    <button class="close" type="button" id="flash-msg-remove">
                        <span class="font-weight-light"></span>
                        <i class="fas fa-times icon-sucess" style="font-size: 0.73em"></i>
                    </button>
                </div>
            <?php } ?>

            <!-- Flash Message Error -->
            <?php
            if (Application::$app->session->getFlashMessage('error')) { ?>
                <div class="alert alert-danger" id="flash-msg-alert">
                    <strong>Error!</strong>
                    <?php echo Application::$app->session->getFlashMessage('error'); ?>
                    <button class="close" type="button" id="flash-msg-remove">
                        <span class="font-weight-light"></span>
                        <i class="fas fa-times icon-warning" style="font-size: 0.73em"></i>
                    </button>
                </div>
            <?php } ?>

            <!-- Flash Message Alert -->
            <?php
            if (Application::$app->session->getFlashMessage('alert')) { ?>
                <div class="alert alert-warning" id="flash-msg-alert">
                    <strong>Alert!</strong>
                    <?php echo Application::$app->session->getFlashMessage('alert'); ?>
                    <button class="close" type="button" id="flash-msg-remove">
                        <span class="font-weight-light"></span>
                        <i class="fas fa-times icon-warning" style="font-size: 0.73em"></i>
                    </button>
                </div>
            <?php } ?>


            <div class="tab-container">
                <div class="search-N-sort-components-container">
                    <div>
                        <p class="page-step-title">
                            Select permission
                        </p>
                    </div>
                </div>

                <div class="user-group-container">

                    <?php if ($params['page_step'] == 3) { ?>
                        <div class="item-info-container">
                            <p class='item-info-name'>Content Collection</p>
                            <div class='item-info-block'>
                                <p class='item-info-header-block'>Name</p>
                                <span>:</span>
                                <p><?= $params['collection'] ?></p>
                            </div>
                        </div>

                        <div class="item-info-container">
                            <p class='item-info-name'>User Group</p>

                            <div class='item-info-block'>
                                <p class='item-info-header-block'>Name</p>
                                <span>:</span>
                                <p><?= $params['usergroup']->name ?></p>
                            </div>

                            <div class='item-info-block'>
                                <p class='item-info-header-block'>Creator</p>
                                <span>:</span>
                                <p><?= $params['usergroup']->first_name ?> <?= $params['usergroup']->last_name ?></p>
                            </div>

                            <div class='item-info-block'>
                                <p class='item-info-header-block'>Description</p>
                                <span>:</span>
                                <p><?php if ($params['usergroup']->description == '') {
                                        echo 'N/A';
                                    } else {
                                        echo $params['usergroup']->description;
                                    } ?></p>
                            </div>
                        </div>


                        <form class='permission-form' action="" method="POST">
                            <input type="hidden" name="collection-id" value="<?= $params['collection-id'] ?>" />
                            <input type="hidden" name="usergroup-id" value="<?= $params['usergroup']->id ?>" />
                            <input type="hidden" name="redirect" value="<?= $params['redirect'] ?>" />
                            <div class='radio-btns-container'>
                                <div class='radio-btn-input-group'>
                                    <input type="radio" name='permission' value="1" <?php if (isset($params['currentPermission']) && $params['currentPermission']  && $params['currentPermission']->permission == 1) echo "checked" ?> />
                                    <label>READ ONLY</label>
                                </div>
                                <div class='radio-btn-input-group'>
                                    <input type="radio" name='permission' value="2" <?php if (isset($params['currentPermission']) && $params['currentPermission'] && $params['currentPermission']->permission == 2) echo "checked" ?> />
                                    <label>READ/DOWNLOAD</label>
                                </div>

                            </div>
                            <?php if (isset($params['permissionModel'])) { ?>
                                <?php foreach ($params['permissionModel']->errors['permission'] as $error) { ?>
                                    <p class='danger-text'>* <?= $error ?></p>
                                <?php } ?>
                            <?php } ?>
                            <div class='permission-form-btns-container'>
                                <button class='btn action-btn-2-edit btn-update' type="submit">Submit</button>
                                <button id='cancel-btn' class='btn action-btn-3-edit btn-update' type="button">Cancel</button>
                            </div>
                        </form>
                    <?php } ?>




                </div>
            </div>
        </div>
    </div>
    <?php
    include_once dirname(__DIR__) . '/components/footer.php';
    ?>

    <script src="/javascript/nav.js"></script>
    <script src="/javascript/profile.js"></script>

    <Script>
        (() => {

            const flashMessage = document.getElementById('flash-msg-alert');
            const flashMessageAlertDeteteBtn = document.getElementById('flash-msg-remove');
            const cancelBtn = document.getElementById('cancel-btn');

            if (flashMessageAlertDeteteBtn) {
                flashMessageAlertDeteteBtn.onclick = function() {
                    flashMessage.remove();
                }
            }

            cancelBtn.addEventListener('click', () => {
                window.location = '/admin/set-access-permission';
            })

        })();
    </Script>

</body>

</html>