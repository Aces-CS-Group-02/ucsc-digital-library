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
    $content = $params['content'];
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
                <button class="btn <?php echo '' . ($params['upload_steps'] >= 1 ? "btn-info" : "btn-light") . ''; ?> mr-1 step-next-btn" onclick="window.location='/admin/upload-content?content_id=<?php echo $params['data']['content_id']; ?>';" <?php echo '' . ($params['upload_steps'] >= 1 ? "" : "disabled") . ''; ?>>Step 1</button>
                <button class="btn <?php echo '' . ($params['upload_steps'] >= 3 ? "btn-info" : "btn-light") . ''; ?> mr-1 step-next-btn" onclick="window.location='/admin/upload-content/metadata?content_id=<?php echo $params['data']['content_id']; ?>';" <?php echo '' . ($params['upload_steps'] >= 2 ? "" : "disabled") . ''; ?>>Step 2</button>
                <button class="btn <?php echo '' . ($params['upload_steps'] >= 3 ? "btn-info" : "btn-light") . ''; ?> mr-1 step-next-btn" onclick="window.location='/admin/upload-content/insert-keyword-abstract?content_id=<?php echo $params['data']['content_id']; ?>';" <?php echo '' . ($params['upload_steps'] >= 2 ? "" : "disabled") . ''; ?>>Step 3</button>
                <button class="btn <?php echo '' . ($params['upload_steps'] >= 4 ? "btn-info" : "btn-light") . ''; ?> mr-1 step-next-btn" onclick="window.location='/admin/upload-content/upload-file?content_id=<?php echo $params['data']['content_id']; ?>';" <?php echo '' . ($params['upload_steps'] >= 3 ? "" : "disabled") . ''; ?>>Step 4</button>
                <button class="btn btn-primary mr-1 step-next-btn">Step 5</button>

            </div>



            <form id="create-community-form" action="" method="POST">
                <div class="input-row-group">

                    <div class="card type-column border-1 card-margin">
                        <div class="card-title" style="background-color: rgba(0, 0, 0, 0.03)">
                            <p>Collection</p>
                        </div>
                        <div class="card-content-override fw-400">
                            <div class="input-row">
                                <?php echo $params['collection']->parent->name . ' > ' . $params['collection']->name; ?>
                            </div>
                            <div class="input-row content-align-right">
                                <button class="btn btn-secondary" onclick="window.location='/admin/upload-content?content_id=<?php echo $params['data']['content_id']; ?>';" type="button">Edit</button>
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
                                    <b>Creator(s)</b>
                                </div>
                                <div class="input-column-2">
                                    <p>
                                        <?php
                                        echo $params['creators'][0]['creator'];
                                        for ($i = 1; $i < count($params['creators']); $i++) {
                                            echo ', ' . $params['creators'][$i]['creator'];
                                        } ?>
                                    </p>
                                </div>
                            </div>
                            <div class="input-row">
                                <div class="input-column-1">
                                    <b>Title</b>
                                </div>
                                <div class="input-column-2">
                                    <p><?php echo $content->title; ?></p>
                                </div>
                            </div>

                            <?php if ($content->publisher != null and $content->publisher != '') { ?>
                                <div class="input-row">
                                    <div class="input-column-1">
                                        <b>Publisher</b>
                                    </div>
                                    <div class="input-column-2">
                                        <p><?php echo $content->publisher; ?></p>
                                    </div>
                                </div>
                            <?php } ?>
                            <div class="input-row">
                                <div class="input-column-1">
                                    <b>Date of Issue</b>
                                </div>
                                <div class="input-column-2">
                                    <p><?php
                                        $date = new DateTime($content->date);
                                        echo $date->format('Y-m-d'); ?></p>
                                </div>
                            </div>
                            <div class="input-row">
                                <div class="input-column-1">
                                    <b>Type</b>
                                </div>
                                <div class="input-column-2">
                                    <p><?php echo $params['type']->name; ?></p>
                                </div>
                            </div>
                            <div class="input-row">
                                <div class="input-column-1">
                                    <b>Language</b>
                                </div>
                                <div class="input-column-2">
                                    <p><?php echo $params['language']->language; ?></p>
                                </div>
                            </div>
                            <?php if ($content->isbn != null and $content->isbn != '') { ?>
                                <div class="input-row">
                                    <div class="input-column-1">
                                        <b>ISBN</b>
                                    </div>
                                    <div class="input-column-2">
                                        <p><?php echo $content->isbn; ?></p>
                                    </div>
                                </div>
                            <?php } ?>
                            <div class="input-row content-align-right">
                                <button class="btn btn-secondary" onclick="window.location='/admin/upload-content/metadata?content_id=<?php echo $params['data']['content_id']; ?>';" type="button">Edit</button>
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
                                    <?php
                                    echo $params['keywords'][0]['keyword'];
                                    for ($i = 1; $i < count($params['keywords']); $i++) {
                                        echo ', ' . $params['keywords'][$i]['keyword'];
                                    } ?>
                                </div>
                            </div>
                            <div class="input-row">
                                <div class="input-column-1">
                                    <b>Abstract</b>
                                </div>
                                <div class="input-column-2">
                                    <p><?php echo $content->abstract; ?></p>
                                </div>
                            </div>
                            <div class="input-row content-align-right">
                                <button class="btn btn-secondary" onclick="window.location='/admin/upload-content/insert-keyword-abstract?content_id=<?php echo $params['data']['content_id']; ?>';" type="button">Edit</button>
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
                                    <a href="http://localhost:8000/<?php echo $content->url; ?>">Click here to view the file</a>
                                </div>
                            </div>
                            <div class="input-row content-align-right">
                                <button class="btn btn-secondary" onclick="window.location='/admin/upload-content/upload-file?content_id=<?php echo $params['data']['content_id']; ?>';" type="button">Edit</button>
                            </div>
                        </div>
                    </div>

                    <div class="btn-row content-align-right">
                        <button class="btn btn-danger mr-1" onclick="window.location='/admin/dashboard/manage-content';" type="button">Cancel</button>
                        <button class="btn btn-secondary mr-1" onclick="window.location='/admin/upload-content/upload-file?content_id=<?php echo $params['data']['content_id']; ?>';" type="button">Back</button>
                        <button class="btn btn-primary mr-1" type="submit">Finish</button>
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