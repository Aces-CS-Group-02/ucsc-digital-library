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
    <link rel="stylesheet" href="/css/local-styles/profile.css">
    <link rel="stylesheet" href="/css/local-styles/edit-profile.css">


    <title>Document</title>
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
            <div class="user-profile-avatar" style="background-image: url(/assets/profile/profile.jpeg);">

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
                        <p id="user-role-id"><?php echo $userRole; ?></p>
                    </div>

                    <p><?php echo $userEmail['email'] ?></p>
                </div>

                <!-- <div class="user-profile-settings-btn-container">



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

                </div> -->
            </div>


        </div>
    </div>

    <div class="edit-profile-main-content">

        <div class="profile-section-a wrapper">
            <div class="section-header">
                <p class="section-header-title">Edit Profile</p>
                <!-- <a class="section-header-view-all" href="#">View All</a> -->
            </div>


            <div class="form edit-profile-form">

                <div class="edit-profile-form-inputs-section">
                    <div class="edit-profile-form-side-a">
                        <div class="input-group edit-profile-form-input-group">
                            <label class="labelPlace" for="">First Name</label>
                            <input class="form-control" id="name" type="text" placeholder="Enter your name" value="<?php echo $userName['firstname'] ?>" />
                        </div>
                        <div class="input-group edit-profile-form-input-group">
                            <label class="labelPlace" for="">Last Name</label>
                            <input class="form-control" id="name" type="text" placeholder="Enter your name" value="<?php echo $userName['lastname'] ?>" />
                        </div>
                        <div class="input-group edit-profile-form-input-group">
                            <label class="labelPlace" for="">Email</label>
                            <input class="form-control" id="name" type="text" placeholder="Enter your name" value="<?php echo $userEmail['email'] ?>" />
                        </div>
                    </div>
                    <div class="edit-profile-form-side-b">
                        <div class="input-group edit-profile-form-input-group">
                            <label class="labelPlace" for="">Current Password</label>
                            <div class="form-password">
                                <input class="inputStyle" id="password" type="password" />
                                <button id="hide-btn" type="button">
                                    <i class="fas fa-eye-slash"></i>
                                </button>
                            </div>
                        </div>
                        <div class="input-group edit-profile-form-input-group">
                            <label class="labelPlace" for="">New Password</label>
                            <div class="form-password">
                                <input class="inputStyle" id="password" type="password" />
                                <button id="hide-btn" type="button">
                                    <i class="fas fa-eye-slash"></i>
                                </button>
                            </div>
                        </div>
                        <div class="input-group edit-profile-form-input-group">
                            <label class="labelPlace" for="">Re-Enter New Password</label>
                            <div class="form-password">
                                <input class="inputStyle" id="password" type="password" />
                                <button id="hide-btn" type="button">
                                    <i class="fas fa-eye-slash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="edit-profile-form-submit-btn-section">
                    <input class="btn btn-primary mr-1 mb-1" id="profile-edit-save-btn-edit" type="submit" value="Save">
                </div>

            </div>

        </div>
    </div>


    <!-- FOOTER -->

    <?php
    include_once dirname(__DIR__) . '/components/footer.php';
    ?>
    <script src="/javascript/nav.js"></script>
    <script src="/javascript/profile.js"></script>
</body>

</html>