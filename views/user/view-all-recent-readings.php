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
    <link rel="stylesheet" href="/css/local-styles/view-all-content-notes.css">



    <title>My Content Notes</title>
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

                <div class="user-profile-settings-btn-container">

                    <div class="each-btn-container">
                        <a class="user-profile-settings-btn" href="/profile/edit">
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

    <!-- Section C (Content Notes) -->

    <div class="profile-section-a wrapper">
        <div class="section-header">
            <p class="section-header-title">Recent Readings</p>
        </div>

        <div class="profile-grid">
            <?php
            $recentReadings = $params['allRecentReadings'] ?? "";
            ?>
            <?php if (empty($recentReadings)) { ?>
                <p class="no-records-available">No Records Available :(</p>
            <?php } else { ?>

                <?php foreach ($recentReadings as $content) { ?>


                    <a href="/content/view?content_id=<?= $content->content_id ?>" class="edit-link">
                        <div class="profile-gird-container profile-section-b">

                            <div class="profile-grid-item box-shadow-2">
                                <div class="content-card">
                                    <div class="content-card-img">
                                        <img src="/<?= $content->thumbnail ?>" alt="">
                                    </div>
                                    <div class="content-card-bottom">
                                        <p class="line-clamp line-clamp-2-description" name="content_id" value="<?php $content->content_id ?>"> <?php echo $content->title ?></p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </a>
            <?php }
            } ?>
        </div>
    </div>

    <!-- FOOTER -->

    <?php
    include_once dirname(__DIR__) . '/components/footer.php';
    ?>

    <script src="/javascript/nav.js"></script>
</body>

</html>