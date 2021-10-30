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
    <link rel="stylesheet" href="/css/local-styles/info-verify-new-users.css">



    <title>Document</title>
</head>

<body>

    <!-- NAVIGATION BAR -->

    <?php
    include_once dirname(dirname(__DIR__)) . '/components/nav.php';
    ?>


    <div class="info-dashboard-main-content">
        <div class="admin-dashboard-text">
            <p id="page-header-title">Verify New Users</p>
            <?php include_once dirname(dirname(__DIR__)) . '/components/breadcrum.php'; ?>
        </div>


        <div class="table-responsive table-margin">
            <div class="btn-grid-container">
                <div class="btn-container">
                    <button class="btn btn-success mr-1 mb-1" type="button">Approve</button>
                    <button class="btn btn-danger mr-1 mb-1" type="button">Reject</button>
                </div>
            </div>
            <div class="info-items-container">


                <!-- ID -->

                <div class="info-item-container first-node">
                    <div class="info-item-title">
                        <p>Request_ID:</p>
                    </div>
                    <div class="info-item-content">
                        <p>1001</p>
                    </div>
                </div>

                <!-- First Name -->

                <div class="info-item-container ">
                    <div class="info-item-title">
                        <p>First Name:</p>
                    </div>
                    <div class="info-item-content">
                        <p>Ramza</p>
                    </div>
                </div>

                <!-- First Name -->
                <div class="info-item-container ">
                    <div class="info-item-title">
                        <p>Last Name:</p>
                    </div>
                    <div class="info-item-content">
                        <p>Mohideen</p>
                    </div>
                </div>


                <!-- Email -->

                <div class="info-item-container">
                    <div class="info-item-title">
                        <p>Email:</p>
                    </div>
                    <div class="info-item-content">
                        <p>ramzamohideen@gmail.com</p>
                    </div>
                </div>

                <!-- Verification URI -->

                <div class="info-item-container ">
                    <div class="info-item-title">
                        <p>Verification:</p>
                    </div>
                    <div class="info-item-content ">
                        <a href="http://dl.ucsc.cmb.ac.lk/sds4564">View Verification Attachment</a>
                    </div>
                </div>

                <!-- Message -->
                <div class="info-item-container">
                    <div class="info-item-title">
                        <p>Message:</p>
                    </div>
                    <div class="info-item-content">
                        <p>This is the request message</p>
                    </div>
                </div>
                <!-- Requested Date -->

                <div class="info-item-container  last">
                    <div class="info-item-title">
                        <p>Requested Date:</p>
                    </div>
                    <div class="info-item-content">
                        <p>17-09-2021</p>
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