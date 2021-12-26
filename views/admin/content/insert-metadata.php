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
    <link rel="stylesheet" href="/css/local-styles/insert-metadata.css">

    <!-- jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>


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
            <p id="page-header-title">Upload Content: Insert Metadata</p>
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
                <a href="/admin/insert-metadata" class="btn btn-primary mr-1 step-next-btn">Step 2</a>
                <a href="/admin/insert-keyword-abstract" class="btn btn-light mr-1 step-next-btn">Step 3</a>
                <a href="/admin/submit-content" class="btn btn-light mr-1 step-next-btn">Step 4</a>
                <a href="/admin/verify-submission" class="btn btn-light mr-1 step-next-btn">Step 5</a>
            </div>


            <form id="create-community-form" action="" method="POST">
                <div class="input-row-group">

                    <div class="input-row" id="creators">
                        <div class="input-column-1">
                            <label class="labelPlace required" for="creator[]">Creator</label>

                        </div>
                        <div class="input-column-2">
                            <div class="multiple-creator">
                                <?php if (count($params['creators']) > 0) { ?>
                                    <div class="input-row">
                                        <input class="form-control" name="creators[]" type="text" placeholder="Enter the name of the creator" value="<?php echo $params['creators'][0]; ?>" />
                                    </div>
                                    <?php for ($i = 1; $i < count($params['creators']); $i++) { ?>
                                        <div class="input-row"><input class="form-control" name="creators[]" type="text" placeholder="Enter the name of the creator" value="<?php echo $params['creators'][$i] ?>" /><button class="btn btn-danger mr-1 delete-creator remove_button" type="button">Remove</button> </div>
                                    <?php } ?>
                                <?php } else { ?>
                                    <div class="input-row">
                                        <input class="form-control" name="creators[]" type="text" placeholder="Enter the name of the creator" />
                                    </div>
                                <?php } ?>
                            </div>
                            <button class="btn btn-secondary btn-override add_button" type="button">Add another creator</button>
                        </div>
                    </div>

                    <div class="input-row">
                        <div class="input-column-1">
                            <label class="labelPlace required" for="title">Title</label>

                        </div>
                        <div class="input-column-2">
                            <input class="form-control" name="title" id="title" type="text" placeholder="Enter the title of the content" value="<?php echo $params['content']->title; ?>" />
                        </div>
                    </div>

                    <div class="input-row">
                        <div class="input-column-1">
                            <label class="labelPlace required" for="subject">Subject</label>

                        </div>
                        <div class="input-column-2">
                            <input class="form-control" name="subject" id="subject" type="text" placeholder="Enter the subject of the content" value="<?php echo $params['content']->subject; ?>" />
                        </div>
                    </div>

                    <div class="input-row">
                        <div class="input-column-1">
                            <label class="labelPlace" for="date">Date of issue</label>

                        </div>
                        <div class="input-column-2">
                            <input class="form-control" name="date" id="name" type="date" placeholder="Enter the date of issue" <?php if (strtotime($params['content']->publish_date) != '0000-00-00') {
                                                                                                                                    $date = new DateTime($params['content']->publish_date);
                                                                                                                                    echo 'value="' . $date->format('Y-m-d') . '"';
                                                                                                                                } ?> />
                        </div>
                    </div>


                    <div class="input-row">
                        <div class="input-column-1">
                            <label class="labelPlace required" for="language">Language</label>

                        </div>
                        <div class="input-column-2">
                            <select class="custom-select custom-select-override" name="language">
                                <?php foreach ($params['languages'] as $language) { ?>
                                    <option value="<?php echo $language->language_id; ?>" <?php if ($language->language_id == $params['content']->language) echo "selected"; ?>><?php echo $language->language; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="input-row">
                        <div class="input-column-1">
                            <label class="labelPlace" for="type">Select the type: </label>

                        </div>
                        <div class="input-column-2">
                            <select class="custom-select custom-select-override" name="type">
                                <?php foreach ($params['contentTypes'] as $contentType) { ?>
                                    <option value="<?php echo $contentType->content_type_id; ?>"><?php echo $contentType->name; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="input-row">
                        <div class="input-column-1">
                            <label class="labelPlace" for="publisher">Publisher</label>

                        </div>
                        <div class="input-column-2">
                            <input class="form-control" name="publisher" id="publisher" type="text" placeholder="Enter the publisher of the content" value="<?php echo $params['content']->publisher; ?>" />
                        </div>
                    </div>

                    <div class="input-row">
                        <div class="input-column-1">
                            <label class="labelPlace" for="isbn">ISBN</label>

                        </div>
                        <div class="input-column-2">
                            <input class="form-control" name="isbn" id="isbn" type="text" placeholder="Enter the ISBN of the content" value="<?php echo $params['content']->isbn; ?>" />
                        </div>
                    </div>

                    <div class="btn-row content-align-right">
                        <button class="btn btn-danger mr-1" type="button">Cancel</button>
                        <button class="btn btn-warning mr-1" type="button">Draft</button>
                        <a href="/admin/upload-content" class="btn btn-secondary mr-1 step-next-btn">Back</a>
                        <!-- <a class="btn btn-primary mr-1 step-next-btn" type="submit">Next</a> -->
                        <button class="btn btn-primary mr-1" type="submit">Next</button>

                    </div>
                </div>
            </form>





        </div>
    </div>
    <?php
    include_once dirname(dirname(__DIR__)) . '/components/footer.php';
    ?>

    <script src="/javascript/nav.js"></script>

    <script>
        $(document).ready(function() {
            var maxField = 10; //Input fields increment limitation
            var addButton = $('.add_button'); //Add button selector
            var wrapper = $('.multiple-creator'); //Input field wrapper
            var fieldHTML = '<div class="input-row"><input class="form-control" name="creators[]" type="text" placeholder="Enter the name of the creator" /><button class="btn btn-danger mr-1 delete-creator remove_button" type="button">Remove</button> </div>'; //New input field html 
            var x = 1; //Initial field counter is 1

            //Once add button is clicked
            $(addButton).click(function() {
                //Check maximum number of input fields
                if (x < maxField) {
                    x++; //Increment field counter
                    $(wrapper).append(fieldHTML); //Add field html
                }
            });

            //Once remove button is clicked
            $(wrapper).on('click', '.remove_button', function(e) {
                e.preventDefault();
                $(this).parent('div').remove(); //Remove field html
                x--; //Decrement field counter
            });
        });
    </script>
</body>

</html>