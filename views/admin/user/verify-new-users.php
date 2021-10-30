<?php
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
    <link rel="stylesheet" href="/css/local-styles/verify-new-users.css">


    <title>Document</title>
</head>

<body>
    <!-- NAVIGATION BAR -->

    <?php
    include_once dirname(dirname(__DIR__)) . '/components/nav.php';
    ?>


    <!-- VERIFY NEW USERS PAGE -->

    <div class="page-header-container">
        <p id="page-header-title">Verify New Users</p>
        <?php include_once dirname(dirname(__DIR__)) . '/components/breadcrum.php'; ?>
    </div>

    <div class="second-border">
        <!-- Flash Message -->
        <?php

        use app\core\Application;

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

        <?php


        if (Application::$app->session->getFlashMessage('error')) { ?>


            <div class="alert alert-success" id="flash-msg-alert">
                <strong>Success!</strong>

                <?php echo Application::$app->session->getFlashMessage('error'); ?>

                <button class="close" type="button" id="flash-msg-remove">
                    <span class="font-weight-light"></span>
                    <i class="fas fa-times icon-sucess" style="font-size: 0.73em"></i>
                </button>
            </div>


        <?php } ?>
        <div class="search-N-sort-components-container">
            <div class="search-component-container">
                <form action="">
                    <div class="ug-search-input-wrapper">
                        <input type="text" placeholder="Search new users">
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
                            <option value="1">Registered Date</option>
                            <option value="2">User Email</option>
                            <option value="3">Name</option>
                        </select>
                    </div>
                </form>
            </div>
        </div>

        <div class="button-place" id="buttonDiv">
            <button class="btn btn-success mr-1 mb-1 btn2-edit" type="button">Bulk Approve</button>
            <button class="btn btn-danger mr-1 mb-1 btn3-edit edit" type="button">Bulk Reject</button>
        </div>

    </div>

    <!-- USER GROUPS INFORMATION -->

    <div class="content-container">

        <div class="new-users-headers-container">
            <div class="block-a"> </div>
            <div class="block-b">Registered Date</div>
            <div class="block-c">User Email</div>
            <div class="block-d">Verification</div>
            <div class="block-d">Name</div>
            <div class="block-e">Action</div>
        </div>

        <div class="new-user-container">

            <?php foreach ($params['model'] as $request) { ?>
                <div class="new-user-info">
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
                            <p>Registered Date</p>
                            <p>:</p>
                        </div>
                        <p><?php
                            $date = new DateTime($request->date);
                            echo $date->format('Y-m-d'); ?></p>
                    </div>
                    <div class="block-c">
                        <div class="block-title">
                            <p>User Email</p>
                            <p>:</p>
                        </div>
                        <p><?php echo $request->email; ?></p>
                    </div>
                    <div class="block-d">
                        <div class="block-title">
                            <p>Verification</p>
                            <p>:</p>
                        </div>
                        <p> <a href="http://localhost:8000/<?php echo $request->verification; ?>" target="_blank">View</a></p>
                    </div>
                    <div class="block-d">
                        <div class="block-title">
                            <p>Name</p>
                            <p>:</p>
                        </div>
                        <p><?php echo $request->first_name; ?> <?php echo $request->last_name; ?></p>
                    </div>
                    <div class="block-e">
                        <p>
                            <button class="btn btn-info mr-1 mb-1 btn1-edit" type="button">View</button>
                            <button class="btn btn-success mr-1 mb-1 btn2-edit" onclick="approve(<?php echo $request->request_id; ?>)" type="button">Approve</button>
                            <button class="btn btn-danger mr-1 mb-1 btn3-edit" onclick="reject(<?php echo $request->request_id; ?>)" type="button">Reject</button>
                        </p>
                    </div>
                </div>
            <?php } ?>

            <?php if (empty($communities)) { ?>
                <p class="no-records-available">No Records Available :(</p>
            <?php } ?>

        </div>
    </div>

    </div>

    <!-- FOOTER -->

    <?php
    include_once dirname(dirname(__DIR__)) . '/components/footer.php';
    ?>

    <!-- SCRITPT -->

    <script src="/javascript/nav.js"></script>
    <script src="/javascript/verify-new-users.js"></script>
    <script src="/javascript/alert.js"></script>


    <script>
        function approve(request_id) {
            var form = document.createElement('form');
            var element = document.createElement("input");

            form.method = "POST";
            form.action = "/admin/verify-new-users";

            element.value = request_id;
            element.name = "request_id";
            element.type = "hidden";
            form.appendChild(element);

            // form.setAttribute('method', 'post');
            // form.setAttribute('action', '/admin/verify-new-users?'+request_id);
            form.style.display = 'hidden';
            document.body.appendChild(form)
            // console.log(form);
            form.submit();
        }

        function reject(request_id) {
            var form = document.createElement('form');
            var element = document.createElement("input");

            form.method = "POST";
            form.action = "/admin/reject-new-user";

            element.value = request_id;
            element.name = "request_id";
            element.type = "hidden";
            form.appendChild(element);

            // form.setAttribute('method', 'post');
            // form.setAttribute('action', '/admin/verify-new-users?'+request_id);
            form.style.display = 'hidden';
            document.body.appendChild(form)
            // console.log(form);
            if (confirm("Are you sure ?")) {
                form.submit();
            }
        }
    </script>

</body>

</html>