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
    <link rel="stylesheet" href="/css/global-styles/paginate.css">

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

            <div class="tab-btn-container">
                <a class="tab-link-btn active" href="/admin/manage-usergroup?usergroup-id=<?php echo $params['group']->id ?>">Manage Users</a>
                <a class="tab-link-btn blured" href="/admin/add-users?usergroup-id=<?php echo $params['group']->id ?>">Add Users</a>

            </div>

            <div class="second-border">

                <!-- <div class="upper-container">
                    <div class="button-place">
                        <form action="/admin/create-user-group/review" method="POST">
                            <button class="btn btn-primary mr-1 mb-1" id="btn-edit" disabled>Proceed</button>
                        </form>
                    </div>
                </div> -->

                <div class="search-N-sort-components-container">
                    <div class="search-component-container">
                        <form action="" method="GET">
                            <div class="ug-search-input-wrapper">
                                <input type="text" hidden name='usergroup-id' value="<?php echo $params['group']->id ?>">
                                <input type="text" placeholder="Search users" name='q' value="<?php echo $params['search_params'] ?? '' ?>">
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

                <?php if ($params['show_request_approval_btn']) { ?>
                    <div class="create-new-community-btn-container">
                        <form action="/admin/request-ug-approval" method='POST' id='request-approval-form'>
                            <input type="text" id='request-approval-data-field' hidden name='group_id' value='<?php echo $params['group']->id ?>'>
                        </form>
                        <button class="btn btn-primary" id="request-approval-btn" data-groupid='<?php echo $params['group']->id ?>'>Request approval</button>
                    </div>
                <?php } ?>

            </div>



            <div class="bulk-select-place" id="buttonDiv">
                <p id="checked-items-container"></p>
                <p class="space-editor">Selected:</p>
                <form action="/push-user-to-user-group" method="POST">
                    <button class="btn btn-danger mr-1 mb-1 btn2-edit" name='user_reg_no' value="<?php echo $params['group']->id ?>">Add User</button>
                </form>
            </div>

            <!-- ADD USERS INFORMATION -->

            <div class="content-container">

                <div class="add-users-headers-container">
                    <div class="block-a"> </div>
                    <div class="block-b">First Name</div>
                    <div class="block-c">Last Name</div>
                    <div class="block-d">Email</div>
                    <?php if (Application::getUserRole() <= 2) { ?>
                        <div class="block-d">User Role</div>
                    <?php } ?>
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
                            <?php if (Application::getUserRole() <= 2) { ?>
                                <div class="block-d">
                                    <div class="block-title">
                                        <p>User Role</p>
                                        <p>:</p>
                                    </div>
                                    <p><span class="badge badge-soft-<?php if ($student->role_id == 1) echo "danger";
                                                                        else if ($student->role_id == 2) echo "warning";
                                                                        else if ($student->role_id == 3) echo "primary";
                                                                        else if ($student->role_id == 4) echo "success";
                                                                        else echo "secondary";
                                                                        ?>"><?php echo Application::$app->getUserRoleNameByID($student->role_id); ?></span></p>
                                </div>
                            <?php } ?>

                            <div class="block-f">
                                <form action="/usergroup/remove-user" method="POST">
                                    <input type="hidden" name="usergroup_id" value="<?php echo $params['group']->id ?>">
                                    <input type="hidden" name="user_reg_no" value="<?php echo $student->reg_no; ?>">
                                    <button class="btn btn-add btn-danger">Remove</button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php } ?>


                <?php if (empty($params['users_list'])) { ?>
                    <p class="no-records-available">No Records Available :(</p>
                <?php } ?>

                <?php

                if (!empty($params['users_list']) && isset($params['pageCount'])) {
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
    <script src=" /javascript/nav.js"></script>
    <script src="/javascript/add-users.js"></script>

    <Script>
        (() => {
            const dataObj = new Map();
            const requestApprovalBtn = document.getElementById('request-approval-btn');
            const requstApprovalForm = document.getElementById('request-approval-form');
            const requestApprovalDataField = document.getElementById('request-approval-data-field');

            dataObj.set(requestApprovalBtn, requestApprovalBtn.dataset.groupid);
            dataObj.set(requestApprovalDataField, requestApprovalDataField.name);

            const requestApproval = function() {
                requestApprovalBtn.dataset.groupid = dataObj.get(requestApprovalBtn);
                requestApprovalDataField.name = dataObj.get(requestApprovalDataField);
                requestApprovalDataField.value = dataObj.get(requestApprovalBtn);

                if (confirm('Are youre sure? Once you made the request you will not able to edit this group until it get approved. But you can remove it anytime.')) {
                    requstApprovalForm.submit();
                }

            }
            requestApprovalBtn.addEventListener('click', requestApproval, false);
        })();
    </Script>


</body>

</html>