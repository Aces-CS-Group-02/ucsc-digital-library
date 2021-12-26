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
    <link rel="stylesheet" href="/css/local-styles/insert-keyword-abstract.css">

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
            <p id="page-header-title">Upload Content: Insert Keyword(s) and Abstract</p>
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
                <a href="/admin/insert-keyword-abstract" class="btn btn-primary mr-1 step-next-btn">Step 3</a>
                <a href="/admin/submit-content" class="btn btn-light mr-1 step-next-btn">Step 4</a>
                <a href="/admin/verify-submission" class="btn btn-light mr-1 step-next-btn">Step 5</a>
            </div>


            <form id="create-community-form" action="" method="POST">
                <div class="input-row-group">

                    <div class="input-row">
                        <div class="input-column-1">
                            <label class="labelPlace" for="keywords[]">Keyword(s)</label>

                        </div>
                        <div class="input-column-2">
                            <div class="multiple-keyword">
                                <?php if (count($params['keywords']) > 0) { ?>
                                    <div class="input-row">
                                        <input class="form-control" name="keywords[]" type="text" placeholder="Enter a keyword" value="<?php echo $params['keywords'][0]; ?>" />
                                    </div>
                                    <?php for ($i = 1; $i < count($params['keywords']); $i++) { ?>
                                        <div class="input-row"><input class="form-control" name="keywords[]" type="text" placeholder="Enter a keyword" value="<?php echo $params['keywords'][$i] ?>" /><button class="btn btn-danger mr-1 delete-keyword remove_button" type="button">Remove</button> </div>
                                    <?php } ?>
                                <?php } else { ?>
                                    <div class="input-row">
                                        <input class="form-control" name="keywords[]" type="text" placeholder="Enter a keyword" />
                                    </div>
                                <?php } ?>
                            </div>
                            <button class="btn btn-secondary btn-override add_button" type="button">Add another keyword</button>
                        </div>
                    </div>

                    <div class="input-row">
                        <div class="input-column-1">
                            <label class="labelPlace" for="">Abstract</label>

                        </div>
                        <div class="input-column-2">
                            <textarea class="form-control" name="abstract" placeholder="Enter the abstract of the content" id="" cols="30" rows="10"><?php echo $params['content']->abstract; ?></textarea>
                        </div>
                    </div>

                    <div class="btn-row content-align-right">
                        <button class="btn btn-danger mr-1" type="button">Cancel</button>
                        <button class="btn btn-warning mr-1" type="button">Draft</button>
                        <a href="/admin/insert-metadata" class="btn btn-secondary mr-1 step-next-btn">Back</a>
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
            var wrapper = $('.multiple-keyword'); //Input field wrapper
            var fieldHTML = '<div class="input-row"><input class="form-control" name="keywords[]" type="text" placeholder="Enter a keyword" /><button class="btn btn-danger mr-1 delete-keyword remove_button" type="button">Remove</button> </div>'; //New input field html 
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