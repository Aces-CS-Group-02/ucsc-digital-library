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
    <link rel="stylesheet" href="/css/local-styles/verify-submission.css">
    <title>Upload Content</title>
</head>

<body>

    <!-- NAVIGATION BAR -->



    <?php
    include_once dirname(dirname(__DIR__)) . '/components/nav.php';
    ?>

    <!-- Main Content Container -->

    <div id="update-user-main-content">
        <div class="page-header-container">
            <p id="page-header-title">Upload Content: Verify Submission</p>
            <?php include_once dirname(dirname(__DIR__)) . '/components/breadcrum.php'; ?>

        </div>

        <div class="wrapper">

            <!-- Flash Message -->
            <?php

            use app\core\Application;

            if (Application::$app->session->getFlashMessage('success-community-creation')) { ?>


                <div class="alert alert-success" id="flash-msg-alert">
                    <strong>Success!</strong>

                    <?php echo Application::$app->session->getFlashMessage('success-community-creation'); ?>

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


            <div class="btn-row">
                <a href="/admin/upload-content" class="btn btn-info mr-1 step-next-btn">Step 1</a>
                <a href="/admin/insert-metadata" class="btn btn-info mr-1 step-next-btn">Step 2</a>
                <a href="/admin/insert-keyword-abstract" class="btn btn-info mr-1 step-next-btn">Step 3</a>
                <a href="/admin/submit-content" class="btn btn-info mr-1 step-next-btn">Step 4</a>
                <a href="/admin/verify-submission" class="btn btn-primary mr-1 step-next-btn">Step 5</a>

            </div>



            <form id="create-community-form" action="" method="POST">
                <div class="input-row-group">

                    <div class="card type-column border-1 card-margin">
                        <div class="card-title" style="background-color: rgba(0, 0, 0, 0.03)">
                            <p>Collection</p>
                        </div>
                        <div class="card-content-override fw-400">
                            <div class="input-row">
                                Selected collection appear here
                            </div>
                            <div class="input-row content-align-right">
                                <button class="btn btn-secondary" type="button">Edit</button>
                            </div>
                        </div>
                    </div>

                    <div class="card type-column border-1 card-margin">
                        <div class="card-title" style="background-color: rgba(0, 0, 0, 0.03)">
                            <p>Meta Data</p>
                        </div>
                        <div class="card-content-override fw-400">
                            <div class="input-row">
                                <div class="input-column-1">
                                    <b>Creator</b>
                                </div>
                                <div class="input-column-2">
                                    <p>Name of the creator</p>
                                </div>
                            </div>
                            <div class="input-row">
                                <div class="input-column-1">
                                    <b>Ttile</b>
                                </div>
                                <div class="input-column-2">
                                    <p>Title of the content</p>
                                </div>
                            </div>
                            <div class="input-row">
                                <div class="input-column-1">
                                    <b>PUblisher</b>
                                </div>
                                <div class="input-column-2">
                                    <p>Publisher of the content</p>
                                </div>
                            </div>
                            <div class="input-row">
                                <div class="input-column-1">
                                    <b>Date of Issue</b>
                                </div>
                                <div class="input-column-2">
                                    <p>Date of issue of the content</p>
                                </div>
                            </div>
                            <div class="input-row">
                                <div class="input-column-1">
                                    <b>Type</b>
                                </div>
                                <div class="input-column-2">
                                    <p>Type of the content</p>
                                </div>
                            </div>
                            <div class="input-row content-align-right">
                                <button class="btn btn-secondary" type="button">Edit</button>
                            </div>
                        </div>
                    </div>

                    <div class="card type-column border-1 card-margin">
                        <div class="card-title" style="background-color: rgba(0, 0, 0, 0.03)">
                            <p>Keyword(s) and Abstract</p>

                        </div>
                        <div class="card-content-override fw-400">
                            <div class="input-row">
                                <div class="input-column-1">
                                    <b>Keyword(s)</b>
                                </div>
                                <div class="input-column-2">
                                    <p>keyword1, keyword2, keyword3</p>
                                </div>
                            </div>
                            <div class="input-row">
                                <div class="input-column-1">
                                    <b>Abstract</b>
                                </div>
                                <div class="input-column-2">
                                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Vel dolor alias quibusdam reprehenderit quisquam maxime fuga aliquam officiis. Odio et harum doloribus tempora architecto natus, cumque mollitia hic libero debitis.</p>
                                </div>
                            </div>
                            <div class="input-row content-align-right">
                                <button class="btn btn-secondary" type="button">Edit</button>
                            </div>
                        </div>
                    </div>

                    <div class="card type-column border-1 card-margin">
                        <div class="card-title" style="background-color: rgba(0, 0, 0, 0.03)">
                            <p>Uploaded file</p>
                        </div>
                        <div class="card-content-override fw-400">
                            <div class="input-row">
                                <div class="input-column-1">
                                    <b>File</b>
                                </div>
                                <div class="input-column-2">
                                    <a href="link to the file">Click here to view the file</a>
                                </div>
                            </div>
                            <div class="input-row content-align-right">
                                <button class="btn btn-secondary" type="button">Edit</button>
                            </div>
                        </div>
                    </div>

                    <div class="btn-row content-align-right">
                        <button class="btn btn-danger mr-1" type="button">Cancel</button>
                        <button class="btn btn-warning mr-1" type="button">Draft</button>
                        <a href="/admin/submit-content" class="btn btn-secondary mr-1 step-next-btn">Back</a>
                        <button class="btn btn-primary mr-1" type="button">Finish</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <?php
    include_once dirname(dirname(__DIR__)) . '/components/footer.php';
    ?>

    <script src="/javascript/nav.js"></script>
</body>

</html>