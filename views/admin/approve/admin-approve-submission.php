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
    <link rel="stylesheet" href="/css/global-styles/paginate.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Aces css framework -->
    <link rel="stylesheet" href="/css/aces-css-framework/style.css">

    <!-- Local Styles -->
    <link rel="stylesheet" href="/css/local-styles/admin-approve-submission.css">



    <title>Approve Submissions</title>
</head>

<body>

    <!-- NAVIGATION BAR -->

    <?php
    include_once dirname(dirname(__DIR__)) . '/components/nav.php';
    ?>
    <!-- APPROVE CONTENT CATEGORIES PAGE -->

    <div class="page-header-container">
        <p id="page-header-title">Approve Submissions</p>
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
                        <input type="text" placeholder="Search contents by title" name='q' value="<?php echo $params['search_params'] ?? '' ?>">
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
                            <option value="1">Title</option>
                            <option value="2">Submitted By</option>
                            <option value="3">Submitted Date</option>
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

    <!-- CONTENT CATEGORIES INFORMATION -->

    <div class="content-container">

        <div class="content-categories-headers-container">
            <!-- <div class="block-a"> </div> -->
            <div class="block-b">Submitted Date</div>
            <div class="block-c">Title</div>
            <div class="block-d">Submitted By</div>
            <div class="block-e">Action</div>

        </div>

        <div class="content-category-container">
            <?php foreach ($params['contents'] as $content) { ?>
                <div class="content-category-info">
                    <!-- <div class="block-a">
                        <p>
                        <div class="input-group custom-control">
                            <div class="checkbox checkbox-edit">
                                <input class="checkbox checkbox-edit" type="checkbox" id="check" onclick="DivShowHide(this)" />
                            </div>
                        </div>
                        </p>
                    </div> -->
                    <div class="block-b">
                        <div class="block-title">
                            <p>Submitted Date</p>
                            <p>:</p>
                        </div>
                        <p><?php echo $content->date; ?></p>
                    </div>
                    <div class="block-c">
                        <div class="block-title">
                            <p>Title</p>
                            <p>:</p>
                        </div>
                        <p><?php echo $content->title; ?></p>
                    </div>
                    <div class="block-d">
                        <div class="block-title">
                            <p>Submitted By</p>
                            <p>:</p>
                        </div>
                        <p><?php echo $content->uploader; ?></p>
                    </div>
                    <div class="block-e">
                        <!-- <p> -->
                            <button class="btn btn-info mr-1 mb-1 btn1-edit" type="button">View</button>
                            <button class="btn btn-success mr-1 mb-1 btn2-edit" onclick="showModal(true,this,<?= $content->content_id ?>)" type="button">Approve</button>
                            <button class="btn btn-danger mr-1 mb-1 btn3-edit" onclick="showModal(false,this,<?= $content->content_id ?>)" type="button">Reject</button>
                        <!-- </p> -->
                    </div>
                </div>
            <?php } ?>

            <?php if (empty($params['contents'])) { ?>
                <p class="no-records-available">No Records Available :(</p>
            <?php } ?>

            <div id="approveModal" class="modal">

                <div class="modal-content" id="modal-content">
                    <form id="modal-form" action="" method="POST">
                        <div class="modal-top-section modal-title">
                            <div class="title-section">
                                <p id="mtitle"></p>
                            </div>
                            <div class="close">
                                <span class="edit-close">&times;</span>
                            </div>
                        </div>
                        <div class="input-group edit-input-group">
                            <input type="textarea" class="form-control edit-form-control" id="reason" name="reason" placeholder="Enter the reason"></input>
                        </div>
                        <div class="modal-bottom-section">
                            <button class="btn btn-info mr-1 mb-1" name="content_id" id="idOut" type="submit">Okay</button>
                        </div>
                    </form>
                </div>

            </div>

            <?php

            if (!empty($params['contents']) && isset($params['pageCount'])) {
                include_once dirname(dirname(__DIR__)) . '/components/paginate.php';
            }
            ?>
        </div>

    </div>
    <!-- FOOTER -->

    <?php
    include_once dirname(dirname(__DIR__)) . '/components/footer.php';
    ?>
    <script src="/javascript/nav.js"></script>
    <script src="/javascript/alert.js"></script> <!-- :( -->
    <script src="/javascript/admin-approve-submission.js"></script>

</body>

</html>