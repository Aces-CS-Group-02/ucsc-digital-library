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
    <link rel="stylesheet" href="/css/local-styles/review-lend-requests.css">


    <title>Review Lend Requests</title>
</head>

<body>

    <!-- NAVIGATION BAR -->

    <?php
    include_once dirname(dirname(__DIR__)) . '/components/nav.php';
    ?>

    <!-- APPROVE USER GROUPS PAGE -->

    <div class="page-header-container">
        <p id="page-header-title">Review Lend Requests</p>
        <!-- <hr class="divider"> -->
        <?php include_once dirname(dirname(__DIR__)) . '/components/breadcrum.php'; ?>

    </div>

    <div class="wrapper">

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
                        <input type="text" placeholder="Search user groups" name='q'>
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
                            <!-- <option value="0"></option> -->
                            <option value="1">Name</option>
                            <option value="2">Created Date</option>
                            <option value="3">Creator</option>
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

        <div class="user-groups-headers-container">
            <!-- <div class="block-a"> </div> -->
            <!-- <div class="block-b">Created Date</div> -->
            <div class="block-b">Content</div>
            <div class="block-c">User</div>
            <div class="block-d">Lend period (Weeks)</div>
            <div class="block-e">Action</div>
        </div>

        <div class="user-group-container">
            <?php foreach ($params['requests'] as $req) { ?>
                <div class="user-group-info">
                    <!-- <div class="block-a">
                        <p>
                        <div class="input-group custom-control">
                            <div class="checkbox checkbox-edit">
                                <input class="checkbox checkbox-edit" type="checkbox" id="check" onclick="DivShowHide(this)" />
                            </div>
                        </div>
                        </p>
                    </div> -->
                    <!-- <div class="block-b">
                        <div class="block-title">
                            <p>Created Date</p>
                            <p>:</p>
                        </div>
                        <p></p>
                    </div> -->
                    <div class="block-b">
                        <div class="block-title">
                            <p>Name</p>
                            <p>:</p>
                        </div>
                        <p><?= $req->content_title ?></p>
                    </div>
                    <div class="block-c">
                        <div class="block-title">
                            <p>Name</p>
                            <p>:</p>
                        </div>
                        <p><?= $req->user_first_name ?>&nbsp;<?= $req->user_last_name ?></p>
                    </div>
                    <div class="block-d">
                        <div class="block-title">
                            <p>Creator</p>
                            <p>:</p>
                        </div>
                        <p><?= $req->lend_duration ?></p>
                    </div>
                    <div class="block-e">
                        <!-- <a href="/admin/review-user-group?id=<?= $req->id ?>">
                            <button class="btn btn-info mr-1 mb-1 btn1-edit" type="submit">View</button>
                        </a> -->
                        <form action="/admin/process-lend-request/approve" method="POST">
                            <input type="hidden" name="request_id" value="<?= $req->request_id ?>">
                            <button class="btn btn-success mr-1 mb-1 btn2-edit" type="submit">Approve</button>
                        </form>
                        <!-- <form action="" method="POST"> -->
                        <button class="btn btn-danger mr-1 mb-1 btn3-edit reject-btn" type="submit" data-reqid="<?= $req->request_id ?>">Reject</button>
                        <!-- </form> -->
                    </div>
                </div>
            <?php } ?>
        </div>

        <div id="reject-message-container">
            <p>Reject Lend Request</p>
            <form action="/admin/process-lend-request/reject" method="POST">
                <label>Please enter the cause for reject this lend request</label>
                <textarea id='rejection-msg-input' name='message'></textarea>
                <input id='req-info' type="hidden" name='req_id' />
                <button type="submit">Submit</button>
                <button id='rejection-popup-close-btn' type="button">Cancel</button>
            </form>
        </div>

        <div id='full-overlay'></div>

        <?php if (empty($params['requests'])) { ?>
            <p class="no-records-available">No Records Available :(</p>
        <?php } ?>

        <?php

        if (!empty($params['requests']) && isset($params['pageCount'])) {
            include_once dirname(dirname(__DIR__)) . '/components/paginate.php';
        }
        ?>

    </div>

    <!-- FOOTER -->

    <div class="footer-edit">
        <?php
        include_once dirname(dirname(__DIR__)) . '/components/footer.php';
        ?>
    </div>

    <!-- SCRITPT -->

    <script src="/javascript/nav.js"></script>
    <script src="/javascript/approve-user-groups.js"></script>

    <script>
        (() => {
            const rejectMsgContainer = document.getElementById('reject-message-container');
            const overlay = document.getElementById('full-overlay');
            const rejectBtns = document.getElementsByClassName('reject-btn');
            const cancelBtn = document.getElementById('rejection-popup-close-btn');

            rejectMsgContainer.style.display = 'none';

            const reject = ({
                currentTarget
            }) => {
                overlay.classList.add('open')
                rejectMsgContainer.style.display = 'block';
                document.getElementById('req-info').value = currentTarget.dataset.reqid;
            }

            const cancelRejection = () => {
                overlay.classList.remove('open')
                rejectMsgContainer.style.display = 'none';
            }

            overlay.addEventListener('click', cancelRejection, false);

            cancelBtn.addEventListener('click', cancelRejection, false);

            for (rejectBtn of rejectBtns) {
                rejectBtn.addEventListener('click', reject, false);
            }
        })()
    </script>
</body>

</html>