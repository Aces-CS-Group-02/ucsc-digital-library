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
    <link rel="stylesheet" href="/css/global-styles/paginate.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Aces css framework -->
    <link rel="stylesheet" href="/css/aces-css-framework/style.css">

    <!-- Local Styles -->
    <link rel="stylesheet" href="/css/local-styles/manage-all-user-groups.css">




    <title>Create Library Information Assistant</title>
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


            <div class="search-N-sort-components-container">
                <div class="search-component-container">
                    <form action="" method="GET">
                        <div class="ug-search-input-wrapper">
                            <input type="text" placeholder="Search content collections" name='q' value="<?php echo $params['search_params'] ?? '' ?>">
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

            <div class="create-new-community-btn-container">
                <button class="btn btn-primary" id="create-new-community-btn">Create new content collection</button>
            </div>

            <!-- Form goes here -->
            <div class="user-groups-headers-container">
                <div class="block-a"> </div>
                <div class="block-b">Name</div>
                <div class="block-b">Description</div>
                <div class="block-c">Status</div>
                <div class="block-d">Action</div>
            </div>

            <div class="user-group-container">

                <?php
                $obj1 = new stdClass;
                $obj1->group_id = 100;
                $obj1->name = 'SCS2112 Automata Theory';
                $obj1->description = '';

                $obj1->status = 'live';

                $usergroups = [$obj1];

                $obj2 = new stdClass;
                $obj2->group_id = 101;
                $obj2->name = 'SCS2112 Automata Theory';
                $obj2->description = '';

                $obj2->status = 'draft';


                $usergroups = [$obj2];

                $obj3 = new stdClass;
                $obj3->group_id = 102;
                $obj3->name = 'Professional Development';
                $obj3->description = '';

                $obj3->status = 'draft';

                $usergroups = [$obj3];

                $obj4 = new stdClass;
                $obj4->group_id = 103;
                $obj4->name = 'Programming Language Concepts';
                $obj4->description = '';

                $obj4->status = 'live';

                $usergroups = [$obj1, $obj2, $obj3, $obj4];




                ?>

                <!-- This is for print top border of the first record at every time -->
                <div class="user-group-info"></div>

                <!-- This loop render all the communities to the page -->
                <?php if ($usergroups) {
                    foreach ($usergroups as $usergroup) { ?>

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

                                <p><?php echo $usergroup->name ?></p>
                            </div>
                            <div class="block-b">
                                <div class="block-title">
                                    <p>Description</p>
                                    <p>:</p>
                                </div>
                                <p class="line-clamp line-clamp-2-description row-description <?php if ($usergroup->description === "") {
                                                                                                    echo "gray-out";
                                                                                                } ?>"><?php


                                                                                                        if ($usergroup->description === "") {
                                                                                                            echo "N/A";
                                                                                                        } else {
                                                                                                            echo $usergroup->description;
                                                                                                        }


                                                                                                        ?></p>
                            </div>
                            <div class="block-c">
                                <div class="block-title">
                                    <p>Creator</p>
                                    <p>:</p>
                                </div>
                                <p><span class="badge badge-soft-<?php if ($usergroup->status == 'live') echo "success";
                                                                    else if ($usergroup->status == 'pending') echo "warning";
                                                                    else if ($usergroup->status == 'draft') echo "secondary";
                                                                    ?>"><?php echo $usergroup->status; ?></span></p>
                            </div>
                            <div class="block-d">
                                <a href="/admin/manage-usergroup?usergroup-id=<?php echo $usergroup->group_id ?>" class="btn btn-add btn-danger btn-edit-user-group">Edit</a>

                                <?php if ($usergroup->group_id > 1) { ?>
                                    <form action="" method="POST">
                                        <button class="btn btn-add btn-danger btn2-edit ml-2" type="submit" name="group_id" value="<?php echo $usergroup->group_id; ?>" data-id="<?php echo $usergroup->group_id; ?>">Remove</button>
                                    </form>
                                <?php } ?>
                            </div>
                        </div>

                <?php }
                } ?>

                <?php if (empty($usergroups)) { ?>
                    <p class="no-records-available">No Records Available :(</p>
                <?php } ?>



                <?php

                if (!empty($usergroups) && isset($params['pageCount'])) {
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

            const createnewcommunityBtn = document.getElementById('create-new-community-btn');
            createnewcommunityBtn.onclick = function() {

                window.location = '/admin/admin-create-content-collection';

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