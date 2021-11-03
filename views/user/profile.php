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
    <link rel="stylesheet" href="./css/global-styles/style.css">
    <link rel="stylesheet" href="./css/global-styles/nav.css">
    <link rel="stylesheet" href="./css/global-styles/footer.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Aces css framework -->
    <link rel="stylesheet" href="./css/aces-css-framework/style.css">

    <!-- Local Styles -->
    <link rel="stylesheet" href="./css/local-styles/profile.css">



    <title>My Profile</title>
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

                    <!-- <div class="each-btn-container">
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
                    </div> -->

                </div>
            </div>


        </div>
    </div>


    <!-- Section A -->

    <div class="profile-section-a wrapper">

        <!-- Flash Message Success -->
        <?php

        if (Application::$app->session->getFlashMessage('success')) { ?>


            <div class="alert alert-success" id="flash-msg-alert">
                <strong>Success!</strong>

                <?php echo Application::$app->session->getFlashMessage('success'); ?>

                <button class="close" type="button" id="flash-msg-remove">
                    <span class="font-weight-light"></span>
                    <i class="fas fa-times icon-sucess" style="font-size: 0.73em"></i>
                </button>
            </div>


        <?php } ?>




        <!-- Flash Message Error -->
        <?php
        if (Application::$app->session->getFlashMessage('error')) { ?>
            <div class="alert alert-warning" id="flash-msg-alert">
                <strong>Error!</strong>

                <?php echo Application::$app->session->getFlashMessage('error'); ?>

                <button class="close" type="button" id="flash-msg-remove">
                    <span class="font-weight-light"></span>
                    <i class="fas fa-times icon-warning" style="font-size: 0.73em"></i>
                </button>
            </div>
        <?php } ?>

        <div class="section-header">
            <p class="section-header-title">My Collections</p>
            <a class="section-header-view-all" href="profile/my-collections">View All</a>
        </div>
        <div class="profile-grid">
            <?php

            $collections = $params['collections'] ?? "";
            // $first_record = true;
            // if ($collections) {
            //     foreach ($collections as $collection) {
            //         echo $collection['user_collection_id'];
            //     }
            // }
            // echo '<pre>';
            // var_dump($collections);
            // echo '</pre>';

            ?>

            <!-- This is the default user collection -->
            <div class="profile-gird-container">
                <a href="/profile/manage-collection-view" class="edit-link">
                    <div class="profile-grid-item  box-shadow-2">
                        <div class="profile-grid-item-icon-section">
                            <i class="fas fa-book-reader"></i>
                        </div>
                        <div class="profile-grid-item-title-section">
                            <p>Favourites</p>
                        </div>
                    </div>
                </a>
            </div>

            <!-- This loop renders the other created user collections to the page -->
            <?php if ($collections) {
                foreach ($collections as $collection) { ?>
                    <div class="profile-gird-container">
                        <a href="/profile/manage-collection?collection-id=<?php echo $collection['user_collection_id'] ?>" class="edit-link" data-id="<?php echo $collection['user_collection_id'] ?>">
                            <div class="profile-grid-item  box-shadow-2">
                                <div class="profile-grid-item-icon-section">
                                    <i class="fas fa-book-reader"></i>
                                </div>
                                <div class="profile-grid-item-title-section">
                                    <p><?php echo $collection['name'] ?></p>
                                </div>
                            </div>
                        </a>
                    </div>
            <?php }
            } ?>


            <div class="profile-gird-container">
                <a href="/profile/create-user-collection" class="edit-link">
                    <div class="profile-grid-item  box-shadow-2">
                        <div class="profile-grid-item-icon-section" id="create-new-collection">
                            <i class="fas fa-plus"></i>
                        </div>
                    </div>
            </div>
        </div>
    </div>

    <!-- Section B -->

    <div class="profile-section-a wrapper">
        <div class="section-header">
            <p class="section-header-title">Recent Readings</p>
            <a class="section-header-view-all" href="#">View All</a>
        </div>

        <div class="profile-grid">
            <div class="profile-gird-container profile-section-b">
                <a href="/profile/pdf-viewer" class="edit-link">
                    <div class="profile-grid-item box-shadow-2">
                        <div class="content-card ">
                            <div class="content-card-img">
                                <img src="/assets/profile/book-cover.jpg" alt="">
                            </div>
                            <div class="content-card-bottom">
                                <p class="content-card-bottom-title line-clamp line-clamp-2-description">A Christmas Carol</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="profile-gird-container profile-section-b">
                <div class="profile-grid-item box-shadow-2">
                    <div class="content-card">
                        <div class="content-card-img">
                            <img src="https://m.media-amazon.com/images/I/81yh-4QQC8L._AC_UY327_FMwebp_QL65_.jpg" alt="">
                        </div>
                        <div class="content-card-bottom">
                            <p class="content-card-bottom-title line-clamp line-clamp-2-description">Learn Java in one day</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="profile-gird-container profile-section-b">
                <div class="profile-grid-item box-shadow-2">
                    <div class="content-card">
                        <div class="content-card-img">
                            <img src="https://m.media-amazon.com/images/I/810p+IMoNbL._AC_UY327_FMwebp_QL65_.jpg" alt="">
                        </div>
                        <div class="content-card-bottom">
                            <p class="content-card-bottom-title line-clamp line-clamp-2-description">Java coding problems</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="profile-gird-container profile-section-b">
                <div class="profile-grid-item box-shadow-2">
                    <div class="content-card">
                        <div class="content-card-img">
                            <img src="https://m.media-amazon.com/images/I/A1O2e-E1WkL._AC_UY327_FMwebp_QL65_.jpg" alt="">
                        </div>
                        <div class="content-card-bottom">
                            <p class="content-card-bottom-title line-clamp line-clamp-2-description">Learning web design</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="profile-gird-container profile-section-b">
                <div class="profile-grid-item box-shadow-2">
                    <div class="content-card">
                        <div class="content-card-img">
                            <img src="https://m.media-amazon.com/images/I/61wEatFvokL._AC_UY327_FMwebp_QL65_.jpg" alt="">
                        </div>
                        <div class="content-card-bottom">
                            <p class="content-card-bottom-title line-clamp line-clamp-2-description">Modern CSS</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Section C (Bookmarked Contents) -->

    <div class="profile-section-a wrapper">
        <div class="section-header">
            <p class="section-header-title">Bookmarked Contents</p>
            <a class="section-header-view-all" href="#">View All</a>
        </div>

        <div class="profile-grid">
            <div class="profile-gird-container profile-section-b">
                <div class="profile-grid-item box-shadow-2">
                    <div class="content-card">
                        <div class="content-card-img">
                            <img src="https://m.media-amazon.com/images/I/8143qzQAuxL._AC_UY327_FMwebp_QL65_.jpg" alt="">
                        </div>
                        <div class="content-card-bottom">
                            <p class="content-card-bottom-title line-clamp line-clamp-2-description">React coockbook</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="profile-gird-container profile-section-b">
                <div class="profile-grid-item box-shadow-2">
                    <div class="content-card">
                        <div class="content-card-img">
                            <img src="https://m.media-amazon.com/images/I/91I1srPe8DL._AC_UY327_FMwebp_QL65_.jpg" alt="">
                        </div>
                        <div class="content-card-bottom">
                            <p class="content-card-bottom-title line-clamp line-clamp-2-description">Modern C++ programming cookbook</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="profile-gird-container profile-section-b">
                <div class="profile-grid-item box-shadow-2">
                    <div class="content-card">
                        <div class="content-card-img">
                            <img src="https://m.media-amazon.com/images/I/91crsfALwBL._AC_UY327_FMwebp_QL65_.jpg" alt="">
                        </div>
                        <div class="content-card-bottom">
                            <p class="content-card-bottom-title line-clamp line-clamp-2-description">Begining c++ game programming</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="profile-gird-container profile-section-b">
                <div class="profile-grid-item box-shadow-2">
                    <div class="content-card">
                        <div class="content-card-img">
                            <img src="https://m.media-amazon.com/images/I/81bSa9px6qL._AC_UY327_FMwebp_QL65_.jpg" alt="">
                        </div>
                        <div class="content-card-bottom">
                            <p class="content-card-bottom-title line-clamp line-clamp-2-description">Software engineering at google</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="profile-gird-container profile-section-b">
                <div class="profile-grid-item box-shadow-2">
                    <div class="content-card">
                        <div class="content-card-img">
                            <img src="https://m.media-amazon.com/images/I/91FlBY2B6yL._AC_UY327_FMwebp_QL65_.jpg" alt="">
                        </div>
                        <div class="content-card-bottom">
                            <p class="content-card-bottom-title line-clamp line-clamp-2-description">Learning PHP, MySQL, & Javascript</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- FOOTER -->

    <?php
    include_once dirname(__DIR__) . '/components/footer.php';
    ?>

    <script src="./javascript/nav.js"></script>
    <script src="./javascript/alert.js"></script>
</body>

</html>