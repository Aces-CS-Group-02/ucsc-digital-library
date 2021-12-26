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
    <link rel="stylesheet" href="/css/local-styles/select-collection.css">




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
            <p id="page-header-title">Upload Content: Select a Collection & Type</p>
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
                <a href="/admin/upload-content" class="btn btn-primary mr-1 step-next-btn">Step 1</a>
                <a href="/admin/insert-metadata" class="btn btn-light mr-1 step-next-btn">Step 2</a>
                <a href="/admin/insert-keyword-abstract" class="btn btn-light mr-1 step-next-btn">Step 3</a>
                <a href="/admin/submit-content" class="btn btn-light mr-1 step-next-btn">Step 4</a>
                <a href="/admin/verify-submission" class="btn btn-light mr-1 step-next-btn">Step 5</a>
            </div>



            <form id="create-community-form" action="" method="POST">
                <div class="input-row-group">
                    <div class="input-row">
                        <div class="input-column-1">
                            <label class="labelPlace" for="collection_id">Select the collection: </label>

                        </div>
                        <div class="input-column-2">
                            <select class="custom-select custom-select-override" name="collection_id">

                                <?php foreach ($params['collections'] as $collection) { ?>
                                    <option value="<?php echo $collection->collection_id; ?>" <?php if($collection->collection_id==$params['collection_id'])echo 'selected'; ?>><?php echo $collection->parent_community . '>' . $collection->name; ?></option>
                                <?php } ?>

                            </select>
                        </div>



                    </div>
                    
                    <div class="btn-row content-align-right">
                        <button class="btn btn-primary mr-1 mb-1" type="submit">
                            Next
                        </button>
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