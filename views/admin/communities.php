<?php
$isLoggedIn = true;
$userRole = "student";

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

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Aces css framework -->
    <link rel="stylesheet" href="/css/aces-css-framework/style.css">

    <!-- Local Styles -->
    <link rel="stylesheet" href="/css/local-styles/communities-admin-panel.css">




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
            <?php
            if ($params['communityType']) {
                echo "<p id='page-header-title'>Top Level Communities</p>";
            } else {
                echo "<p id='page-header-title'>" . $params['communityname'] ?? "" . "</p>";
            }
            ?>

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
                <div class="alert alert-warning" id="flash-msg-alert">
                    <strong>Error!</strong>

                    <?php echo Application::$app->session->getFlashMessage('error'); ?>

                    <button class="close" type="button" id="flash-msg-remove">
                        <span class="font-weight-light"></span>
                        <i class="fas fa-times icon-warning" style="font-size: 0.73em"></i>
                    </button>
                </div>
            <?php } ?>


            <div class="tab-container">
                <?php if (!$params['communityType']) { ?>
                    <div class="tab-btn-container">
                        <a class="tab-link-btn active" href="/admin/manage-community?community-id=<?php echo $params['parentID'] ?>">Sub Communities (<?php echo $params['subCommunityCount']; ?>)</a>
                        <a class="tab-link-btn blured" href="/admin/manage-community/collections?community-id=<?php echo $params['parentID'] ?>">Collections (<?php echo $params['collectionCount']; ?>)</a>
                    </div>

                <?php } ?>



                <div class="search-N-sort-components-container">
                    <div class="search-component-container">
                        <form action="">
                            <div class="ug-search-input-wrapper">
                                <input type="text" placeholder="Search user groups">
                                <button>
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="sort-component-container">
                        <!-- <form action="">
                        <div class="input-group sort-input-edited" id="adjustments">
                            <label class="labelPlace" for="select">Sort By: </label>
                            <select class="custom-select custom-select-edited" id="select">
                                <option value="0"></option>
                                <option value="1">Name</option>
                                <option value="2">Created Date</option>
                                <option value="3">Creator</option>
                            </select>
                        </div>
                    </form> -->
                        <div class="create-new-community-btn-container">
                            <button class="btn action-btn-0-edit" id="create-new-community-btn">Create <?php if (!$params['communityType']) {
                                                                                                            echo "sub community";
                                                                                                        } else {
                                                                                                            echo "top level community";
                                                                                                        } ?> </button>
                        </div>
                    </div>
                </div>

                <!-- <div class="create-new-community-btn-container">
                <button class="btn action-btn-0-edit" id="create-new-community-btn">Create Top Level Community</button>
            </div> -->

                <!-- Form goes here -->
                <div class="user-groups-headers-container">
                    <div class="block-a"> </div>
                    <div class="block-b">Name</div>
                    <div class="block-c">Description</div>
                    <div class="block-d">Action</div>
                </div>

                <div class="user-group-container">

                    <?php

                    $communities = $params['communities'] ?? "";
                    $first_record = true;

                    ?>

                    <!-- This is for print top border of the first record at every time -->
                    <div class="user-group-info"></div>

                    <!-- This loop render all the communities to the page -->
                    <?php if ($communities) {
                        foreach ($communities as $community) { ?>

                            <div class="user-group-info " data-id="<?php echo $community['community_id'] ?>">
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
                                    <p><?php echo $community['name'] ?></p>
                                </div>
                                <div class="block-c">
                                    <div class="block-title">
                                        <p>Description</p>
                                        <p>:</p>
                                    </div>
                                    <p class="line-clamp line-clamp-2-description row-description <?php if ($community['description'] === "") {
                                                                                                        echo "gray-out";
                                                                                                    } ?>"><?php


                                                                                                            if ($community['description'] === "") {
                                                                                                                echo "N/A";
                                                                                                            } else {
                                                                                                                echo $community['description'];
                                                                                                            }


                                                                                                            ?></p>
                                </div>
                                <div class="block-d">
                                    <div>
                                        <button class="btn action-btn-1-edit btn-view" type="button" data-id="<?php echo $community['community_id'] ?>">Manage</button>
                                        <button class="btn action-btn-2-edit btn-update" type="button" data-id="<?php echo $community['community_id'] ?>">Edit</button>
                                        <button class="btn action-btn-3-edit btn-del" type="button" data-id="<?php echo $community['community_id'] ?>">Delete</button>
                                    </div>
                                </div>
                            </div>

                    <?php }
                    } ?>

                    <?php if (empty($communities)) { ?>
                        <p class="no-records-available">No Records Available :(</p>
                    <?php } ?>


                    <?php

                    if (isset($params['pageCount'])) {
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
            const manageBtns = document.querySelectorAll('.btn-view');
            const deleteBtns = document.querySelectorAll('.btn-del');
            const updateBtns = document.querySelectorAll('.btn-update');
            const rows = document.querySelectorAll('.user-group-info');


            const ID_MAP = new WeakMap();
            const ID_MAP_1 = new WeakMap();
            const ID_MAP_2 = new WeakMap();
            const ID_MAP_3 = [];


            const handleManage = ({
                currentTarget
            }) => {
                if (!ID_MAP_1.has(currentTarget)) return;
                const id_manage = ID_MAP_1.get(currentTarget);
                window.location = `/admin/manage-community?community-id=${id_manage}`;
            }

            const handleDelete = ({
                currentTarget
            }) => {
                // Exit if there is no ID stored
                if (!ID_MAP.has(currentTarget)) return;

                // Retrieve and log ID
                const id = ID_MAP.get(currentTarget);

                console.log(ID_MAP_3[id]);

                console.log(id);

                // AJAX request
                if (confirm("Are you sure?")) {
                    const delRequest = new XMLHttpRequest();
                    let params = [];
                    params = `deleteCommunity=true&community_id=${id}`;
                    delRequest.open('POST', '/ajax/delete-top-level-community');
                    delRequest.onreadystatechange = function() {
                        if (delRequest.responseText === 'success') {
                            if (ID_MAP_3[id]) {
                                ID_MAP_3[id].remove();
                            }
                        }
                    }
                    delRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    delRequest.send(params);
                }


            }


            const handleUpdate = ({
                currentTarget
            }) => {
                // console.log(currentTarget)
                if (!ID_MAP_2.has(currentTarget)) return;

                // Retrieve and log ID
                const id_update = ID_MAP_2.get(currentTarget);
                // console.log(id_update);

                // AJAX request
                window.location = `/admin/edit-community?community-id=${id_update}`;
            }

            // ==========================================================

            for (const btn of manageBtns) {
                // Skip if it doesn't have an ID
                if (!btn.dataset.id) continue;
                // Store and hide `data-id` attribute
                ID_MAP_1.set(btn, btn.dataset.id);
                btn.removeAttribute('data-id');
                // Add event listener
                btn.addEventListener('click', handleManage, false);
            }

            // ============================================================

            for (const btn of deleteBtns) {
                // Skip if it doesn't have an ID
                if (!btn.dataset.id) continue;
                // Store and hide `data-id` attribute
                ID_MAP.set(btn, btn.dataset.id);
                btn.removeAttribute('data-id');
                // Add event listener
                btn.addEventListener('click', handleDelete, false);
            }

            // ===========================================================

            for (const row of rows) {
                // Skip if it doesn't have an ID
                if (!row.dataset.id) continue;
                // Store and hide `data-id` attribute
                // console.log(row.dataset.id.toString())
                let id = row.dataset.id;
                ID_MAP_3[id] = row;
                // console.log(row);
                row.removeAttribute('data-id');
            }



            // ============================================================

            for (const updateBtn of updateBtns) {
                // Skip if it doesn't have an ID
                if (!updateBtn.dataset.id) continue;
                // Store and hide `data-id` attribute
                ID_MAP_2.set(updateBtn, updateBtn.dataset.id);
                updateBtn.removeAttribute('data-id');
                // Add event listener
                updateBtn.addEventListener('click', handleUpdate, false);
            }


            const createnewcommunityBtn = document.getElementById('create-new-community-btn');
            createnewcommunityBtn.onclick = function() {

                <?php if (!$params['communityType']) {
                    echo 'window.location = "/admin/create-sub-community?parent-id=' . $params['parentID'] . '  "';
                } else {
                    echo "window.location = '/admin/create-top-level-community'";
                } ?>

                // window.location = '/create-top-level-communities';
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