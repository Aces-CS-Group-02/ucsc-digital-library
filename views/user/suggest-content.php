<?php
$isLoggedIn = false;

use app\core\Application;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <!-- Global Styles -->
    <link rel="stylesheet" href="./css/global-styles/style.css">
    <link rel="stylesheet" href="./css/global-styles/nav.css">
    <link rel="stylesheet" href="./css/global-styles/footer.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Aces css framework -->
    <link rel="stylesheet" href="./css/aces-css-framework/style.css">

    <!-- Local Styles -->
    <link rel="stylesheet" href="./css/local-styles/search.css">
    <link rel="stylesheet" href="./css/local-styles/suggest-content.css">


    <title>Content Suggestions</title>
</head>

<body>


    <!-- NAVIGATION BAR -->

    <?php
    include_once dirname(__DIR__) . '/components/nav.php';
    ?>

    <!-- SUGGESTING CONTENT -->

    <div class="suggest-content-text">
        Suggest New Content
    </div>

    <div class="main-container">
        <!-- <div class="section-header">
            <p class="section-header-title">My Collections</p>
        </div> -->
        <?php
        // $ContentSuggestionmodel = $params['model'] ?? "";
        // echo '<pre>';
        // var_dump($ContentSuggestionmodel);
        // echo '</pre>';

        $errors_on_title = false;
        $errors_on_creator = false;
        if (isset($params['model']) && $params['model']->hasErrors('title')) {
            $errors_on_title = true;
        }
        if (isset($params['model']) && $params['model']->hasErrors('creator')) {
            $errors_on_creator = true;
        }

        ?>
        <div class="wrapper">
            <form id="create-content-suggestion-form" action="" method="POST">
                <div class="input-group">
                    <label class="labelPlace <?php if ($errors_on_title) {
                                                    echo "danger-text";
                                                } ?>" for="Title">Title</label>
                    <input class="form-control <?php if ($errors_on_title) {
                                                    echo "danger-border";
                                                } ?>" id="Title" type="text" name="title" />

                    <?php
                    if ($errors_on_title) {
                        foreach ($params['model']->errors['title'] as $error) { ?>
                            <div class="validation-error">
                                <i class="fas fa-exclamation-circle"></i>
                                <p><?php echo $error ?></p>
                            </div>
                    <?php }
                    };
                    ?>

                </div>
                <div class="wrapper-inside">
                    <div class="input-group">
                        <label class="labelPlace <?php if ($errors_on_creator) {
                                                        echo "danger-text";
                                                    } ?>" for="Creator">Creator</label>
                        <input class="form-control <?php if ($errors_on_creator) {
                                                        echo "danger-border";
                                                    } ?>" id="Creator" type="text" name="creator" />

                        <?php
                        if ($errors_on_creator) {
                            foreach ($params['model']->errors['creator'] as $error) { ?>
                                <div class="validation-error">
                                    <i class="fas fa-exclamation-circle"></i>
                                    <p><?php echo $error ?></p>
                                </div>
                        <?php }
                        };
                        ?>

                    </div>
                    <div class="input-group">
                        <label class="labelPlace" for="ISBN">ISBN</label>
                        <input class="form-control" id="ISBN" type="text" name="isbn" />
                    </div>
                </div>
                <div class="input-group">
                    <label class="labelPlace" for="information-text-area">Information</label>
                    <textarea class="form-control" id="information-text-area" type="text" name="information"></textarea>
                </div>
                <div class="input-group">
                    <button class="btn btn-primary edit" id="suggest-content-btn">Submit</button>
                </div>
            </form>
        </div>
    </div>

    <!-- FOOTER -->

    <?php
    include_once dirname(__DIR__) . '/components/footer.php';
    ?>

    <!-- SCRITPT -->

    <script src="./javascript/nav.js"></script>
</body>

</html>