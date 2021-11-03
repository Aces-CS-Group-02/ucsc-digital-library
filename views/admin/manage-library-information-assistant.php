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
    <link rel="stylesheet" href="/css/local-styles/manage-library-information-assistant.css">




    <title>Create Library Information Assistant</title>
</head>

<body>

    <!-- NAVIGATION BAR -->
    <?php
    include_once dirname(__DIR__) . '/components/nav.php';

    ?>

    <!-- Main Content Container -->

    <div id="update-user-main-content">
        <div class="page-header-container">
            <p id="page-header-title">Manage Library Information Assistants</p>
            <?php include_once dirname(__DIR__) . '/components/breadcrum.php'; ?>

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
                <button class="btn btn-primary" id="create-new-community-btn">Create new LIA</button>
            </div>

            <!-- Form goes here -->
            <div class="user-groups-headers-container">
                <div class="block-a"> </div>
                <div class="block-b">First Name</div>
                <div class="block-b">Last Name</div>
                <div class="block-c">Email</div>
                <div class="block-d">Action</div>
            </div>

            <div class="user-group-container">

                <?php

                $allStaffMembers = $params['allStaffMembers'] ?? "";

                ?>

                <!-- This is for print top border of the first record at every time -->
                <div class="user-group-info"></div>

                <!-- This loop render all the communities to the page -->
                <?php if ($allStaffMembers) {
                    foreach ($allStaffMembers as $staffMember) { ?>

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
                                    <p>First Name</p>
                                    <p>:</p>
                                </div>
                                <p><?php echo $staffMember['first_name'] ?></p>
                            </div>
                            <div class="block-b">
                                <div class="block-title">
                                    <p>Last Name</p>
                                    <p>:</p>
                                </div>
                                <p><?php echo $staffMember['last_name'] ?></p>
                            </div>
                            <div class="block-c">
                                <div class="block-title">
                                    <p>Email</p>
                                    <p>:</p>
                                </div>
                                <p><?php echo $staffMember['email'] ?></p>
                            </div>
                            <div class="block-d">
                                <div>
                                    <form action="" method="POST" onsubmit="return confirm('Do you really want to remove library information assistant <?php echo $staffMember['first_name'] . ' ' . $staffMember['last_name'] ?>?');" )>
                                        <button class="btn action-btn-0-upgrade btn-upgrade" Name="reg_no" value="<?php echo $staffMember['reg_no'] ?>">Remove</button>
                                    </form>
                                </div>
                            </div>
                        </div>

                <?php }
                } ?>

                <?php if (empty($allStaffMembers)) { ?>
                    <p class="no-records-available">No Records Available :(</p>
                <?php } ?>

            </div>
        </div>
    </div>


    <!-- FOOTER -->
    <?php
    include_once dirname(__DIR__) . '/components/footer.php';
    ?>

    <script src="/javascript/nav.js"></script>
    <script src="/javascript/profile.js"></script>

    <Script>
        (() => {

            const createnewcommunityBtn = document.getElementById('create-new-community-btn');
            createnewcommunityBtn.onclick = function() {

                window.location = '/admin/create-library-information-assistant';

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