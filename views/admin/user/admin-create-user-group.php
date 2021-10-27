<?php
$isLoggedIn = true;
$userRole = "admin";
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
    <link rel="stylesheet" href="/css/local-styles/admin-create-user-group.css">

    <title>Document</title>
</head>

<body>

    <?php
    include_once dirname(dirname(__DIR__)) . '/components/nav.php';
    ?>
    <div class="admin-dashboard-main-content">
        <div class="admin-dashboard-text">
            Create User Groups
        </div>
        <div class="form-container form-container-override">
            <form class="form-feature" action="" method="POST">
                <div class="input-container">
                    <?php

                    $attr_name = 'name';
                    $errors_on_name = false;
                    if (isset($params['model']) && $params['model']->hasErrors($attr_name)) {
                        $errors_on_name = true;
                    }

                    ?>
                    <div class="input-group">
                        <label class="labelPlace label-place-override <?php if ($errors_on_name) {
                                                                            echo "danger-text";
                                                                        } ?>" for="title">User Group Name</label>
                        <input class="form-control form-control-override <?php if ($errors_on_name) {
                                                                                echo "danger-border";
                                                                            } ?>" id="title" type="text" name="name" value="<?php echo $params['model']->name ?? "" ?>">

                        <?php
                        if ($errors_on_name) {
                            foreach ($params['model']->errors[$attr_name] as $error) { ?>
                                <div class="validation-error">
                                    <i class="fas fa-exclamation-circle"></i>
                                    <p><?php echo $error ?></p>
                                </div>
                        <?php }
                        };
                        ?>
                    </div>

                    <div class="input-group">
                        <button class="btn btn-primary mr-1 mb-1 ">Proceed</button>
                    </div>
                </div>
            </form>
        </div>
    </div>







    <!-- FOOTER -->

    <?php
    include_once dirname(dirname(__DIR__)) . '/components/footer.php';
    ?>

    <!-- SCRIPT -->

    <script src="/javascript/nav.js"></script>

</body>

</html>