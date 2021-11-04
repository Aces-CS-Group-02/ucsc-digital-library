<?php

use app\core\Application;

$isLoggedIn = true;
$userRole = "student";

// echo '<pre>';
// var_dump($_SESSION);
// echo '</pre>';




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
                <a class="tab-link-btn active" href="/admin/add-users?usergroup-id=<?php echo $params['group']->group_id ?>">Add Users</a>
                <a class="tab-link-btn blured" href="/admin/manage-usergroup?usergroup-id=<?php echo $params['group']->group_id ?>">Manage</a>
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
                                <input type="text" hidden name='usergroup-id' value="59">
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

            </div>

            <div class="a-to-z-sort-main-container">
                <p id="a-to-z-sort-name">First Name: </p>
                <div class="a-to-z-sort-component-container">
                    <button class="a-to-z-sort-btn a-to-z-all-btn selected">All</button>
                    <button class="a-to-z-sort-btn">A</button>
                    <button class="a-to-z-sort-btn">B</button>
                    <button class="a-to-z-sort-btn">C</button>
                    <button class="a-to-z-sort-btn">D</button>
                    <button class="a-to-z-sort-btn">E</button>
                    <button class="a-to-z-sort-btn">F</button>
                    <button class="a-to-z-sort-btn">G</button>
                    <button class="a-to-z-sort-btn">H</button>
                    <button class="a-to-z-sort-btn">I</button>
                    <button class="a-to-z-sort-btn">J</button>
                    <button class="a-to-z-sort-btn">K</button>
                    <button class="a-to-z-sort-btn">L</button>
                    <button class="a-to-z-sort-btn">M</button>
                    <button class="a-to-z-sort-btn">N</button>
                    <button class="a-to-z-sort-btn">O</button>
                    <button class="a-to-z-sort-btn">P</button>
                    <button class="a-to-z-sort-btn">Q</button>
                    <button class="a-to-z-sort-btn">R</button>
                    <button class="a-to-z-sort-btn">S</button>
                    <button class="a-to-z-sort-btn">T</button>
                    <button class="a-to-z-sort-btn">U</button>
                    <button class="a-to-z-sort-btn">V</button>
                    <button class="a-to-z-sort-btn">W</button>
                    <button class="a-to-z-sort-btn">X</button>
                    <button class="a-to-z-sort-btn">Y</button>
                    <button class="a-to-z-sort-btn">Z</button>

                </div>
            </div>

            <div class="a-to-z-sort-main-container second">
                <p id="a-to-z-sort-name">Last Name: </p>
                <div class="a-to-z-sort-component-container">
                    <button class="a-to-z-sort-btn a-to-z-all-btn selected">All</button>
                    <button class="a-to-z-sort-btn">A</button>
                    <button class="a-to-z-sort-btn">B</button>
                    <button class="a-to-z-sort-btn">C</button>
                    <button class="a-to-z-sort-btn">D</button>
                    <button class="a-to-z-sort-btn">E</button>
                    <button class="a-to-z-sort-btn">F</button>
                    <button class="a-to-z-sort-btn">G</button>
                    <button class="a-to-z-sort-btn">H</button>
                    <button class="a-to-z-sort-btn">I</button>
                    <button class="a-to-z-sort-btn">J</button>
                    <button class="a-to-z-sort-btn">K</button>
                    <button class="a-to-z-sort-btn">L</button>
                    <button class="a-to-z-sort-btn">M</button>
                    <button class="a-to-z-sort-btn">N</button>
                    <button class="a-to-z-sort-btn">O</button>
                    <button class="a-to-z-sort-btn">P</button>
                    <button class="a-to-z-sort-btn">Q</button>
                    <button class="a-to-z-sort-btn">R</button>
                    <button class="a-to-z-sort-btn">S</button>
                    <button class="a-to-z-sort-btn">T</button>
                    <button class="a-to-z-sort-btn">U</button>
                    <button class="a-to-z-sort-btn">V</button>
                    <button class="a-to-z-sort-btn">W</button>
                    <button class="a-to-z-sort-btn">X</button>
                    <button class="a-to-z-sort-btn">Y</button>
                    <button class="a-to-z-sort-btn">Z</button>

                </div>
            </div>

            <div class="bulk-select-place <?php if ($params['current_selected_users']) echo 'display-bulk-operation-btn'; ?>" id="buttonDiv">
                <p id="checked-items-container"><?php if ($params['current_selected_users']) echo count($params['current_selected_users']); ?></p>
                <p class="space-editor">Selected:</p>
                <button class="btn btn-danger mr-1 mb-1 btn2-edit" type="submit" form="main-form">Add User</button>
            </div>

            <!-- ADD USERS INFORMATION -->

            <div class="content-container">

                <div class="add-users-headers-container">
                    <div class="block-a"> </div>
                    <div class="block-b">First Name</div>
                    <div class="block-c">Last Name</div>
                    <div class="block-d">Email</div>
                    <div class="block-f">Action</div>
                </div>

                <!-- <form action="/push-user-to-user-group" method="POST" id='main-form'> -->
                <input type="hidden" name="usergroup_id" value="<?php echo $params['group']->group_id ?>">

                <?php foreach ($params['users_list'] as $student) { ?>
                    <div class="add-users-container">
                        <div class="add-users-info">
                            <div class="block-a">
                                <p>
                                <div class="input-group custom-control">
                                    <div class="checkbox checkbox-edit">
                                        <input class="checkbox checkbox-edit bulk-select-checkbox" type="checkbox" id="check" name='bulkselect[]' value="<?php echo $student->reg_no; ?>" data-id="<?php echo $student->reg_no; ?>" <?php

                                                                                                                                                                                                                                    if (is_array($params['current_selected_users']) && in_array($student->reg_no, $params['current_selected_users'])) {
                                                                                                                                                                                                                                        echo 'checked';
                                                                                                                                                                                                                                    }

                                                                                                                                                                                                                                    ?> />
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
                                <form action="" method="POST">
                                    <button class="btn btn-add" type="submit" name="user_reg_no" value="<?php echo $student->reg_no; ?>" data-id="<?php echo $student->reg_no; ?>">Add</button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <!-- </form> -->

                <?php

                if (isset($params['pageCount'])) {
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

            const checkboxes = document.querySelectorAll('.bulk-select-checkbox');
            const displayLabel = document.getElementById("checked-items-container");
            const buttonDisplay = document.getElementById("buttonDiv");

            const bulkSelect = ({
                currentTarget
            }) => {
                const user_reg_no = currentTarget.dataset.id;
                const selectRequest = new XMLHttpRequest();
                let params = [];
                if (currentTarget.checked) {
                    params = `select-action=true&user_reg_no=${user_reg_no}`;
                } else {
                    params = `select-action=false&user_reg_no=${user_reg_no}`;
                }
                selectRequest.open('POST', '/ajax/usergroup/bulk-select');
                selectRequest.onload = function() {
                    const response_obj = JSON.parse(this.responseText);
                    displayLabel.innerText = response_obj.count;

                    if (response_obj.count > 0) {
                        buttonDisplay.classList.add("display-bulk-operation-btn");
                    } else {
                        buttonDisplay.classList.remove("display-bulk-operation-btn");
                    }

                }
                selectRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                selectRequest.send(params);
            }


            for (checkbox of checkboxes) {
                checkbox.addEventListener('click', bulkSelect, false);
            }

        })();
    </Script>


</body>

</html>