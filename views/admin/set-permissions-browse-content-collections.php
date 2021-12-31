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
    <link rel="stylesheet" href="/css/local-styles/set-permission-browse.css">
    <title>Document</title>
</head>

<body>
    <!-- NAVIGATION BAR -->
    <?php

    use app\core\Application;

    include_once dirname(__DIR__) . '/components/nav.php';
    ?>

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

    <!------------------------- Step 1 ----------------------------->

    <?php if ($params['page_step'] == 1) { ?>
        <form action="/admin/set-content-collection-access-permission/content-collection" method="GET">
            <?php foreach ($params['data'] as $data) { ?>
                <button name='collection-id' value="<?= $data->id ?>">
                    <span><?= $data->name ?></span>
                    <span>
                        <span><?= $data->first_name ?></span>
                        <span><?= $data->last_name ?></span>
                    </span>
                </button>
            <?php } ?>
        </form>
    <?php } ?>

    <!------------------------- Step 2 ----------------------------->

    <?php if ($params['page_step'] == 2) { ?>

        <div>
            <p>Collection: </p>
            <p><?= $params['collection']->name ?></p>
            <div>
                <p><?= $params['collection']->first_name ?></p>
                <p><?= $params['collection']->last_name ?></p>
            </div>

        </div>

        <p>Please choose a user group.</p>
        <form action="/admin/set-content-collection-access-permission/select-permission" method="GET">
            <input type="hidden" name='collection-id' value="<?= $params['collection']->id ?>" />
            <?php foreach ($params['data'] as $usergroup) { ?>
                <div class="usergroup-item-container">
                    <p><?= $usergroup->name ?></p>
                    <p><?= $usergroup->description ?></p>
                    <p><?= $usergroup->first_name ?></p>
                    <p><?= $usergroup->last_name ?></p>
                    <button name='usergroup-id' value="<?= $usergroup->id ?>">Select</button>
                </div>
            <?php } ?>
        </form>
    <?php } ?>


    <!------------------------- Step 3 ----------------------------->

    <?php if ($params['page_step'] == 3) { ?>
        <div>
            <p>Collection: </p>
            <p><?= $params['collection']->name ?></p>
        </div>

        <div>
            <p>User group: </p>
            <p><?= $params['usergroup']->name ?></p>
            <div>
                <p>Created by </p>
                <p><?= $params['usergroup']->first_name ?> <?= $params['usergroup']->last_name ?></p>
            </div>
        </div>

        <p>Please select the permission</p>
        <form action="" method="POST">
            <input type="hidden" name="collection-id" value="<?= $params['collection']->id ?>" />
            <input type="hidden" name="usergroup-id" value="<?= $params['usergroup']->id ?>" />
            <div>
                <input type="radio" name='permission' value="1" />
                <label>Read Only</label>
                <input type="radio" name='permission' value="2" />
                <label>Read/Download</label>
            </div>
            <?php if (isset($params['permissionModel'])) { ?>
                <?php foreach ($params['permissionModel']->errors['permission'] as $error) { ?>
                    <p><?= $error ?></p>
                <?php } ?>
            <?php } ?>
            <button>Submit</button>
        </form>
    <?php } ?>



    <!------------------------- Step 4 ----------------------------->

    <?php if ($params['page_step'] == 4) { ?>

        <?php if ($params['status']) { ?>
            <p>Success</p>
        <?php } else { ?>
            <p>Something went wrong.</p>
        <?php } ?>

        <a href="/admin/set-access-permission">Setup new permission</a>
        <a href="/admin/view-access-permission">View Collection Access permission</a>



    <?php } ?>



    <!------------------------- Step 5----------------------------->

    <?php if ($params['page_step'] == 5) { ?>
        <?php if ($params['data']) { ?>
            <?php foreach ($params['data'] as $item) { ?>
                <div>
                    <p><?= $item->collection ?></p>
                    <p><?= $item->group ?></p>
                    <p><?= $item->permission ?></p>

                    <form action="/remove-permission/collection" method="POST">
                        <input type="hidden" name='collection-id' value="<?= $item->collection_id ?>" />
                        <input type="hidden" name='group-id' value="<?= $item->group_id ?>" />
                        <button>Remove</button>
                    </form>
                </div>
            <?php } ?>
        <?php } ?>
    <?php } ?>

    <!-- Footer -->

    <?php
    include_once dirname(__DIR__) . '/components/footer.php';
    ?>

</body>

</html>