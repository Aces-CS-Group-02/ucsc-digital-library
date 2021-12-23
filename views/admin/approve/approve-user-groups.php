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
    <link rel="stylesheet" href="/css/local-styles/approve-user-groups.css">


    <title>Approve User Groups</title>
</head>

<body>

    <!-- NAVIGATION BAR -->

    <?php
    include_once dirname(dirname(__DIR__)) . '/components/nav.php';
    ?>

    <!-- APPROVE USER GROUPS PAGE -->

    <div class="page-header-container">
        <p id="page-header-title">Approve User Groups</p>
        <!-- <hr class="divider"> -->
        <?php include_once dirname(dirname(__DIR__)) . '/components/breadcrum.php'; ?>

    </div>

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
            <div class="block-a"> </div>
            <div class="block-b">Created Date</div>
            <div class="block-c">Name</div>
            <div class="block-c">Description</div>
            <div class="block-d">Creator</div>
            <div class="block-e">Action</div>
        </div>

        <div class="user-group-container">
            <?php foreach ($params['requests'] as $req) { ?>
                <div class="user-group-info">
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
                            <p>Created Date</p>
                            <p>:</p>
                        </div>
                        <p><?= $req->date ?></p>
                    </div>
                    <div class="block-c">
                        <div class="block-title">
                            <p>Name</p>
                            <p>:</p>
                        </div>
                        <p><?= $req->name ?></p>
                    </div>
                    <div class="block-c">
                        <div class="block-title">
                            <p>Name</p>
                            <p>:</p>
                        </div>
                        <p><?= $req->description ?></p>
                    </div>
                    <div class="block-d">
                        <div class="block-title">
                            <p>Creator</p>
                            <p>:</p>
                        </div>
                        <p><?= $req->first_name ?> <?= $req->last_name ?></p>
                    </div>
                    <div class="block-e">
                        <a href="/admin/review-user-group?id=<?= $req->group_id ?>">
                            <button class="btn btn-info mr-1 mb-1 btn1-edit" type="submit">View</button>
                        </a>
                        <form action="/admin/approve-ug-request" method="POST">
                            <button class="btn btn-success mr-1 mb-1 btn2-edit" type="submit" name="group-id" value="<?= $req->group_id ?>">Approve</button>
                        </form>
                        <form action="" method="POST">
                            <button class="btn btn-danger mr-1 mb-1 btn3-edit" type="submit" name="group-id" value="<?= $req->group_id ?>">Reject</button>
                        </form>
                    </div>
                </div>
            <?php } ?>
        </div>


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

</body>

</html>