<?php
$isLoggedIn = true;


use app\core\Application;

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
    <link rel="stylesheet" href="/css/local-styles/create-user-collection.css">



    <title>New Collection</title>
</head>

<body>

    <!-- NAVIGATION BAR -->

    <?php
    include_once dirname(__DIR__) . '/components/nav.php';
    ?>

    <!-- Profile Top -->

    <div class="profile-banner">
        <div class="profile-banner-img">
        </div>
    </div>

    <div class="profile-user-info wrapper">
        <div class="user-info-container">
            <div class="user-profile-avatar" style="background-image: url(/assets/profile/profile.jpg);">

            </div>


            <div class="user-info-and-btns-container">
                <?php

                $userName = Application::$app->getUserDisplayName();
                $userEmail = Application::$app->getUserEmail();
                $userRole = Application::$app->getUserRoleName();

                ?>
                <div class="user-info">
                    <div class="user-name-and-user-role">
                        <p id="user-name-id"><?php echo $userName['firstname'] . ' ' . $userName['lastname'] ?></p>
                        <p id="user-name-and-role-seperator">|</p>
                        <p id="user-role-id"><?php echo $userRole->name; ?></p>
                    </div>

                    <p><?php echo $userEmail['email'] ?></p>
                </div>

                <div class="user-profile-settings-btn-container">

                    <div class="each-btn-container">
                        <a class="user-profile-settings-btn" href="/edit-profile.php">
                            <i class="fas fa-edit"></i>
                            <p>Edit Profile</p>
                        </a>
                    </div>

                    <div class="each-btn-container">
                        <a class="user-profile-settings-btn" href="/user-activity-log.php">
                            <i class="fas fa-clipboard-list"></i>
                            <p>Activity Log</p>
                        </a>
                    </div>

                    <div class="each-btn-container">
                        <a class="user-profile-settings-btn" href="#">
                            <i class="fas fa-users"></i>
                            <p>User Groups</p>
                        </a>
                    </div>

                </div>
            </div>


        </div>
    </div>


    <!-- Section A -->

    <div class="profile-section-a wrapper">
        <div class="section-header">
            <p class="section-header-title">Create New Collection</p>
        </div>
        <div class="input-division">
            <form id="create-user-collection-form" action="" method="POST">

                <?php {
                    $attr_name = 'name';
                    $errors_on_name = false;
                    if (isset($params['model']) && $params['model']->hasErrors($attr_name)) {
                        $errors_on_name = true;
                    }
                ?>

                    <div class="input-group edit-input-group">
                        <label class="labelPlace <?php if ($errors_on_name) {
                                                        echo "danger-text";
                                                    } ?>" for="Name">Collection Name</label>
                        <input class="form-control <?php if ($errors_on_name) {
                                                        echo "danger-border";
                                                    } ?>" id="Name" type="text" name="name" value="<?php echo $params['model']->name ?? "" ?>" />

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

                <?php } ?>

                <button class="btn btn-primary btn-edit" id="create-user-collection-btn">Create</button>
            </form>
        </div>
    </div>

    <!-- FOOTER -->

    <?php
    include_once dirname(__DIR__) . '/components/footer.php';
    ?>

    <script src="/javascript/nav.js"></script>
</body>

</html>