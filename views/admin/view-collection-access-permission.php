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
    <link rel="stylesheet" href="/css/local-styles/view-access-permission.css">




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
            <p id='page-header-title'>View Access permission</p>


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
                            Granted permissions
                        </p>
                    </div>

                    <div class="search-component-container">
                        <form action="">
                            <div class="ug-search-input-wrapper">
                                <input type="text" placeholder="Search user groups" name='q'>
                                <button>
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>

                </div>


                <div class="user-group-container">
                    <?php foreach ($params['data'] as $data) { ?>
                        <div class="item-info-container">
                            <div class='item-info-info-side'>
                                <div class='item-info-block'>
                                    <p class='item-info-header-block'>Collection Name</p>
                                    <span>:</span>
                                    <p><?= $data->collection ?></p>
                                </div>


                                <div class='item-info-block gray-out-block'>
                                    <p class='item-info-header-block'>Usergroup Name</p>
                                    <span>:</span>
                                    <p><?= $data->group ?></p>
                                </div>

                                <div class='item-info-block make-margin-bottom gray-out-block'>
                                    <p class='item-info-header-block'>Usergroup Owner</p>
                                    <span>:</span>
                                    <p><?= $data->ug_owner_fn ?> <?= $data->ug_owner_ln ?></p>
                                </div>
                                <div class='item-info-block'>
                                    <p class='item-info-header-block'>Permission</p>
                                    <span>:</span>
                                    <p class='permission-label'><?php if ($data->permission == 1) {
                                                                    echo 'READ ONLY';
                                                                } else if ($data->permission == 2) {
                                                                    echo 'READ/DOWNLOAD';
                                                                } ?></p>
                                </div>
                            </div>
                            <div class='item-info-btn-side'>
                                <form action="/admin/remove-permission/collection" method="POST">
                                    <input type='hidden' name='collection-id' value='<?= $data->collection_id ?>' />
                                    <input type='hidden' name='group-id' value='<?= $data->group_id ?>' />
                                    <button class="btn action-btn-3-edit btn-update>Remove">Remove</button>
                                </form>
                            </div>
                        </div>
                    <?php } ?>

                </div>


                <?php if (empty($params['data'])) { ?>
                    <p class="no-records-available">No Records Available :(</p>
                <?php } ?>


                <?php

                if ($params['data']) {
                    include_once dirname(__DIR__) . '/components/paginate.php';
                }
                ?>
            </div>
        </div>
    </div>
    <?php
    include_once dirname(__DIR__) . '/components/footer.php';
    ?>

    <script src=" /javascript/nav.js"></script>
    <script src="/javascript/profile.js"></script>

    <Script>
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