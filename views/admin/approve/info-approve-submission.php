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
    <link rel="stylesheet" href="/css/local-styles/info-approve-submission.css">



    <title>Document</title>
</head>

<body>

    <!-- NAVIGATION BAR -->

    <?php
    include_once dirname(dirname(__DIR__)) . '/components/nav.php';
    ?>


    <div class="info-dashboard-main-content">
        <div class="admin-dashboard-text">
            <p id="page-header-title">Approve Submissions</p>
            <?php include_once dirname(dirname(__DIR__)) . '/components/breadcrum.php'; ?>
        </div>


        <div class="table-responsive table-margin">
            <div class="btn-grid-container">
                <div class="btn-container">
                    <button class="btn btn-success mr-1 mb-1" type="button">Approve</button>
                    <button class="btn btn-danger mr-1 mb-1" type="button">Reject</button>
                </div>
            </div>

            <!-- Content Items -->

            <div class="info-items-container">


                <!-- ID -->

                <div class="info-item-container first-node">
                    <div class="info-item-title">
                        <p>Request_ID:</p>
                    </div>
                    <div class="info-item-content">
                        <p>1002</p>
                    </div>
                </div>

                <!-- Title -->

                <div class="info-item-container ">
                    <div class="info-item-title">
                        <p>Title:</p>
                    </div>
                    <div class="info-item-content">
                        <p>Fundamentals of Software Engineering</p>
                    </div>
                </div>



                <!-- Creators -->

                <div class="info-item-container">
                    <div class="info-item-title">
                        <p>Creator:</p>
                    </div>
                    <div class="info-item-content">
                        <a href="#">Carlo Ghezzi</a>
                        <span class="add-space-with-comma">, </span>
                        <a href="#">Mehdi Jayazeri</a>
                        <span class="add-space-with-comma">, </span>
                        <a href="#">Dino Mandrioli</a>
                    </div>
                </div>


                <!-- Subject -->
                <div class="info-item-container">
                    <div class="info-item-title">
                        <p>Subject:</p>
                    </div>
                    <div class="info-item-content">
                        <p>Software Engineering</p>
                    </div>
                </div>

                <!-- Language -->
                <div class="info-item-container">
                    <div class="info-item-title">
                        <p>Language:</p>
                    </div>
                    <div class="info-item-content">
                        <p>English</p>
                    </div>
                </div>

                <!-- Keywords -->
                <div class="info-item-container">
                    <div class="info-item-title">
                        <p>Keywords:</p>
                    </div>
                    <div class="info-item-content">
                        <p>-</p>
                    </div>
                </div>

                <!-- Published Date -->
                <div class="info-item-container">
                    <div class="info-item-title">
                        <p>Published Date:</p>
                    </div>
                    <div class="info-item-content">
                        <p>19-09-2002</p>
                    </div>
                </div>


                <!-- Publisher -->

                <div class="info-item-container">
                    <div class="info-item-title">
                        <p>Publisher:</p>
                    </div>
                    <div class="info-item-content">
                        <p>Pearson</p>
                    </div>
                </div>


                <!-- ISBN -->

                <div class="info-item-container">
                    <div class="info-item-title">
                        <p>ISBN:</p>
                    </div>
                    <div class="info-item-content">
                        <p>978-0133056990</p>
                    </div>
                </div>

                <!-- Abstract -->
                <div class="info-item-container">
                    <div class="info-item-title">
                        <p>Abstract:</p>
                    </div>
                    <div class="info-item-content">
                        <p>-</p>
                    </div>
                </div>
                <!-- Submitted By -->
                <div class="info-item-container">
                    <div class="info-item-title">
                        <p>Submitted By:</p>
                    </div>
                    <div class="info-item-content">
                        <p>Sadali</p>
                    </div>
                </div>


                <!-- Submitted Date -->
                <div class="info-item-container last">
                    <div class="info-item-title">
                        <p>Submitted Date:</p>
                    </div>
                    <div class="info-item-content">
                        <p>17-09-2021</p>
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