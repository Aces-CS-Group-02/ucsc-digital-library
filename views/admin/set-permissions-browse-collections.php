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
                            <?php if ($params['page_step'] == 1) {
                                echo 'Select a collection';
                            } else if ($params['page_step'] == 2) {
                                echo 'Select a user group';
                            } ?>
                        </p>
                    </div>

                    <div class="search-component-container">
                        <form action="" method="GET">
                            <div class="ug-search-input-wrapper">
                                <input type="hidden" name='collection-id' value='<?= $params['collection']->collection_id ?>'>
                                <input type="text" placeholder="Search user groups" name='q'>
                                <button>
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Form goes here -->
                <div class="user-groups-headers-container">
                    <?php if ($params['page_step'] === 2) { ?>
                        <div class="block-a">Name </div>
                        <div class="block-b">Description</div>
                    <?php } ?>
                    <div class="block-c"><?php if ($params['page_step'] == 1) {
                                                echo 'Collection';
                                            } else if ($params['page_step'] == 2) {
                                                echo 'Creator';
                                            } ?></div>
                    <div class="block-d">Action</div>
                </div>

                <div class="user-group-container">

                    <!-- This is for print top border of the first record at every time -->
                    <div class="user-group-info"></div>

                    <!-- This loop render all the communities to the page -->
                    <?php if ($params['page_step'] == 1) { ?>
                        <?php foreach ($params['data'] as $data) { ?>
                            <div class="user-group-info ">
                                <div class="block-c">
                                    <div class="block-title">
                                        <p>Collection</p>
                                        <p>:</p>
                                    </div>
                                    <p><?= $data->path ?></p>
                                </div>
                                <div class="block-d">
                                    <div>
                                        <form action="/admin/set-access-permission/collections" method="GET">
                                            <button class="btn action-btn-2-edit btn-update" name='collection-id' value="<?= $data->id ?>">Select</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    <?php } ?>


                    <?php if ($params['page_step'] == 2) { ?>
                        <?php foreach ($params['data'] as $data) { ?>

                            <div class="user-group-info ">

                                <div class="block-a">
                                    <div class="block-title">
                                        <p>Name</p>
                                        <p>:</p>
                                    </div>
                                    <p><?= $data->name ?></p>
                                </div>
                                <div class="block-b">
                                    <div class="block-title">
                                        <p>Description</p>
                                        <p>:</p>
                                    </div>
                                    <p class="line-clamp line-clamp-2-description row-description <?php if ($data->description === "") {
                                                                                                        echo "gray-out";
                                                                                                    } ?>"><?php
                                                                                                            if ($data->description === "") {
                                                                                                                echo "N/A";
                                                                                                            } else {
                                                                                                                echo $data->description;
                                                                                                            }
                                                                                                            ?></p>
                                </div>
                                <div class="block-c">
                                    <div class="block-title">
                                        <p>Creator</p>
                                        <p>:</p>
                                    </div>
                                    <p><?= $data->first_name ?> <?= $data->last_name ?></p>
                                </div>
                                <div class="block-d">
                                    <div>

                                        <form action="/admin/set-access-permission/collections/select-permission" method="GET">
                                            <input type="hidden" name='collection-id' value="<?= $params['collection']->collection_id ?>" />
                                            <button class="btn action-btn-2-edit btn-update" name='usergroup-id' value="<?= $data->id ?>">Select</button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        <?php } ?>
                    <?php } ?>

                    <?php if (empty($data)) { ?>
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

            if (flashMessageAlertDeteteBtn) {
                flashMessageAlertDeteteBtn.onclick = function() {
                    flashMessage.remove();
                }
            }

        })();
    </Script>

</body>

</html>