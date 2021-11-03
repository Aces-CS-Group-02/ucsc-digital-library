<?php

use app\core\Application;

$isLoggedIn = true;
$userRole = "student";


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
    <link rel="stylesheet" href="/css/local-styles/add-users.css">



    <title>Document</title>
</head>

<body>

    <!-- NAVIGATION BAR -->

    <?php
    include_once dirname(dirname(__DIR__)) . '/components/nav.php';
    ?>

    <!-- Main Content Container -->

    <div id="add-users-main-content">

        <div class="page-header-container">
            <p id="page-header-title"><?php echo $params['group']->name ?? "" ?></p>
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



            <div class="second-border">

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
                                    <option value="3">Email</option>
                                </select>
                            </div>
                        </form>
                    </div>
                </div>

            </div>



            <div class="bulk-select-place" id="buttonDiv">
                <p id="checked-items-container"></p>
                <p class="space-editor">Selected:</p>
                <form action="/push-user-to-user-group" method="POST">
                    <button class="btn btn-danger mr-1 mb-1 btn2-edit" name='user_reg_no' value="<?php echo $params['group']->group_id ?>">Add User</button>
                </form>
            </div>

            <!-- ADD USERS INFORMATION -->

            <div class="content-container">

                <div class="add-users-headers-container">
                    <div class="block-a"> </div>
                    <div class="block-b">Name</div>
                    <div class="block-c">Status</div>
                    <div class="block-d">Email</div>
                    <div class="block-f">Action</div>
                </div>

                <?php foreach ($params['users_list'] as $student) { ?>
                    <div class="add-users-container">
                        <div class="add-users-info">
                            <div class="block-a">
                                <p>
                                <div class="input-group custom-control">
                                    <div class="checkbox checkbox-edit">
                                        <input class="checkbox checkbox-edit" data-id="<?php echo $student->reg_no; ?>" type="checkbox" id="check" onclick="DivShowHide(this)" />
                                    </div>
                                </div>
                                </p>
                            </div>
                            <div class="block-b">
                                <div class="block-title">
                                    <p>First Name</p>
                                    <p>:</p>
                                </div>
                                <p><?php echo $student->first_name ?></p>
                            </div>
                            <div class="block-c">
                                <div class="block-title">
                                    <p>Last Name</p>
                                    <p>:</p>
                                </div>
                                <p><?php echo $student->last_name ?></p>
                            </div>
                            <div class="block-d">
                                <div class="block-title">
                                    <p>Email</p>
                                    <p>:</p>
                                </div>
                                <p><?php echo $student->email ?></p>
                            </div>

                            <div class="block-f">
                                <!-- <form action="/push-user-to-user-group" method="POST"> -->
                                <input type="hidden" name="usergroup_id" value="<?php echo $params['group']->group_id ?>">
                                <input type="hidden" name="user_reg_no" value="<?php echo $student->reg_no; ?>">
                                <button class="btn btn-add">Remove</button>
                                <!-- </form> -->
                            </div>
                        </div>
                    </div>
                <?php } ?>



            </div>

        </div>

    </div>

    <!-- FOOTER -->

    <?php
    include_once dirname(dirname(__DIR__)) . '/components/footer.php';
    ?>
    <script src=" /javascript/nav.js"></script>
    <script src="/javascript/add-users.js"></script>

    <Script>
        (() => {



        })();
    </Script>


</body>

</html>