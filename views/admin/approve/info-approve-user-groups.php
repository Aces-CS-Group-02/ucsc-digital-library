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
    <link rel="stylesheet" href="/css/local-styles/info-approve-user-groups.css">



    <title>Document</title>
</head>

<body>

    <!-- NAVIGATION BAR -->

    <?php
    include_once dirname(dirname(__DIR__)) . '/components/nav.php';
    ?>


    <div class="info-dashboard-main-content">
        <div class="admin-dashboard-text">
            <p id="page-header-title">Approve User Groups</p>
            <?php include_once dirname(dirname(__DIR__)) . '/components/breadcrum.php'; ?>
        </div>


        <div class="table-responsive table-margin">
            <div class="btn-grid-container">
                <div class="btn-container">
                    <button class="btn btn-success mr-1 mb-1" type="button">Approve</button>
                    <button class="btn btn-danger mr-1 mb-1" type="button">Reject</button>
                </div>
                <div class="info-items-container">


                    <!-- ID -->

                    <div class="info-item-container first-node">
                        <div class="info-item-title">
                            <p>ID:</p>
                        </div>
                        <div class="info-item-content">
                            <p>1001</p>
                        </div>
                    </div>

                    <!-- Title -->

                    <div class="info-item-container ">
                        <div class="info-item-title">
                            <p>User Group Name:</p>
                        </div>
                        <div class="info-item-content">
                            <p>18/19 CS SCS2201 DSA</p>
                        </div>
                    </div>

                    <!-- Issued Date -->
                    <div class="info-item-container ">
                        <div class="info-item-title">
                            <p>Created Date:</p>
                        </div>
                        <div class="info-item-content">
                            <p>17-09-2021</p>
                        </div>
                    </div>


                    <!-- Creators -->

                    <div class="info-item-container">
                        <div class="info-item-title">
                            <p>Creator:</p>
                        </div>
                        <div class="info-item-content">
                            <a href="#">Carlo Ghezzi</a>
                        </div>
                    </div>
                    <!-- Users URI -->
                    <div class="info-item-container">
                        <div class="info-item-title">
                            <p>Users:</p>
                        </div>
                        <div class="info-item-content">
                            <a href="http://dl.ucsc.cmb.ac.lk/sds4564">View Users</a>
                        </div>
                    </div>                  
                </div>
            </div>
        </div>
    </div>

    <!-- FOOTER -->

    <?php
    include_once dirname(dirname(__DIR__)) . '/components/footer.php';
    ?>
    <script src="/javascript/nav.js"></script>

</body>

</html>