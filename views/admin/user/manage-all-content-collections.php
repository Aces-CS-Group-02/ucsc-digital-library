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
    <link rel="stylesheet" href="/css/local-styles/manage-all-user-groups.css">




    <title>Manage Content Collections</title>
</head>

<body>

    <!-- NAVIGATION BAR -->
    <?php
    include_once dirname(dirname(__DIR__)) . '/components/nav.php';
    ?>

    <!-- Main Content Container -->

    <div id="update-user-main-content">
        <div class="page-header-container">
            <p id="page-header-title">Manage Content Collections</p>
            <?php include_once dirname(dirname(__DIR__)) . '/components/breadcrum.php'; ?>


        </div>

        <div class="wrapper">

            <!-- Flash Message Succss -->
            <?php if (Application::$app->session->getFlashMessage('success')) { ?>
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
            <?php if (Application::$app->session->getFlashMessage('error')) { ?>
                <div class="alert alert-warning" id="flash-msg-alert">
                    <strong>Error!</strong>

                    <?php echo Application::$app->session->getFlashMessage('error'); ?>

                    <button class="close" type="button" id="flash-msg-remove">
                        <span class="font-weight-light"></span>
                        <i class="fas fa-times icon-warning" style="font-size: 0.73em"></i>
                    </button>
                </div>
            <?php } ?>


            <div class="search-N-sort-components-container">
                <div class="search-component-container">
                    <form action="" method="GET">
                        <div class="ug-search-input-wrapper">
                            <input type="text" placeholder="Search" name='q' value="<?php echo $params['search_params'] ?? '' ?>">
                            <button>
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
                <div class="sort-component-container">
                    <form action="">
                        <div class="input-group sort-input-edited" id="adjustments">
                            <label class="labelPlace" for="select">Sort By: </label>
                            <select class="custom-select custom-select-edited" id="select">
                                <option value="0"></option>
                                <option value="1">First Name</option>
                                <option value="2">Last Name</option>
                            </select>
                        </div>
                    </form>
                </div>
            </div>

            <div class="create-new-usergroup-btn-container">
                <button class="btn btn-primary" id="create-new-usergroup-btn">Create new user group</button>
            </div>

            <!-- Form goes here -->
            <div class="user-groups-headers-container">
                <div class="block-a"> </div>
                <div class="block-b">Name</div>
                <div class="block-b">Description</div>

                <?php if ($params['is_library_staff_member']) { ?>
                    <div class="block-c">Creator</div>
                <?php } ?>
                <?php if (!$params['is_library_staff_member']) { ?>
                    <div class="block-c">Status</div>
                <?php } ?>

                <div class="block-d">Action</div>
            </div>

            <div class="user-group-container">

                <?php $content_collections = $params['content-collections'] ?? ""; ?>

                <!-- This is for print top border of the first record at every time -->
                <div class="user-group-info"></div>

                <!-- This loop render all the communities to the page -->
                <?php if ($content_collections) { ?>
                    <?php foreach ($content_collections as $content_collection) { ?>

                        <div class="user-group-info ">
                            <div class="block-a">
                                <p>
                                <div class="input-group custom-control">
                                    <div class="checkbox checkbox-edit">
                                        <input class="checkbox checkbox-edit" type="checkbox" id="check" onclick="DivShowHide(this)" />
                                    </div>
                                </div>
                                </p>
                            </div>
                            <div class="block-b">
                                <div class="block-title">
                                    <p>Name</p>
                                    <p>:</p>
                                </div>
                                <p><?php echo $content_collection->name ?></p>
                            </div>
                            <div class="block-b">
                                <div class="block-title">
                                    <p>Description</p>
                                    <p>:</p>
                                </div>
                                <p class="line-clamp line-clamp-2-description row-description <?php if ($content_collection->description === "") {
                                                                                                    echo "gray-out";
                                                                                                } ?>"><?php


                                                                                                        if ($content_collection->description === "") {
                                                                                                            echo "N/A";
                                                                                                        } else {
                                                                                                            echo $content_collection->description;
                                                                                                        }


                                                                                                        ?></p>
                            </div>
                            <div class="block-c">



                                <div class="block-title">
                                    <?php if ($params['is_library_staff_member']) {
                                        echo 'Creator';
                                    } else {
                                        echo 'Status';
                                    } ?>
                                    <p></p>
                                    <p>:</p>
                                </div>

                                <?php if ($params['is_library_staff_member']) { ?>
                                    <p><?php echo $content_collection->first_name . ' ' . $content_collection->last_name ?></p>
                                <?php } ?>
                                <?php if (!$params['is_library_staff_member']) { ?>
                                    <?php
                                    if ($content_collection->status == 1) {
                                        echo '<p class="badge badge-soft-success">' . 'Live' . '</p>';
                                    } else if ($content_collection->status == 3) {
                                        echo '<p class="badge badge-soft-secondary">' . 'Draft' . '</p>';
                                    } else if ($content_collection->status == 2) {
                                        echo '<p class="badge badge-soft-warning">' . 'Pending' . '</p>';
                                    }
                                    ?>
                                <?php } ?>


                                <!-- /admin/remove-user-group -->

                            </div>
                            <div class="block-d">
                                <?php if (Application::$app->user->reg_no == $content_collection->creator) { ?>
                                    <a href="/admin/manage-content-collection?content-collection-id=<?php echo $content_collection->id ?>" class="btn btn-add btn-danger btn-edit-user-group">Edit</a>
                                <?php } ?>

                                <?php if (!$params['is_library_staff_member'] ||  ($params['is_library_staff_member'] && $content_collection->id > 1)) { ?>
                                    <form action="/admin/remove-content-collection" method="POST" id='remove-ug-form'>
                                        <input type="hidden" class='usergroup-remove-dataField' name='content-collection-id' value="<?php echo $content_collection->id; ?>">
                                    </form>
                                    <button class="btn btn-add btn-danger btn2-edit ml-2 remove-ug-btn" id='remove-usergroup-btn' data-groupid="<?php echo $content_collection->id; ?>">Remove</button>
                                <?php } ?>
                            </div>
                        </div>

                    <?php } ?>
                <?php } ?>

                <?php if (empty($content_collections)) { ?>
                    <p class="no-records-available">No Records Available :(</p>
                <?php } ?>



                <?php

                if (!empty($content_collections) && isset($params['pageCount'])) {
                    include_once dirname(dirname(__DIR__)) . '/components/paginate.php';
                }
                ?>

            </div>
        </div>
    </div>


    <!-- FOOTER -->
    <?php
    include_once dirname(dirname(__DIR__)) . '/components/footer.php';
    ?>

    <script src="/javascript/nav.js"></script>
    <script src="/javascript/profile.js"></script>

    <Script>
        (() => {
            const createnewcommunityBtn = document.getElementById('create-new-usergroup-btn');
            const removeUsergroupBtns = document.querySelectorAll('.remove-ug-btn');
            const ugRemoveDataField = document.querySelectorAll('.usergroup-remove-dataField');
            const removeUGForm = document.getElementById('remove-ug-form');

            const dataObj = new Map();
            const dataObj_dataFields = new Map();

            const removeUG = function({
                currentTarget
            }) {
                currentTarget.dataset.groupid = dataObj.get(currentTarget);
                let dataField = dataObj_dataFields.get(dataObj.get(currentTarget));
                dataField.name = 'content-collection-id';
                dataField.value = dataObj.get(currentTarget);

                if (confirm('Do you want to delete this user group?')) removeUGForm.submit();
            }

            for (let dataFiled of ugRemoveDataField) {
                dataObj_dataFields.set(dataFiled.value, dataFiled);
            }
            Object.freeze(dataObj_dataFields);

            for (const btn of removeUsergroupBtns) {
                dataObj.set(btn, btn.dataset.groupid);
                btn.addEventListener('click', removeUG, false);
            }
            Object.freeze(dataObj);









            createnewcommunityBtn.onclick = function() {
                window.location = '/admin/create-content-collection';
            }

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