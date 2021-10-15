
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
            <div class="user-profile-avatar" style="background-image: url(/assets/profile/profile.jpg);">

            </div>


            <div class="user-info-and-btns-container">
                <div class="user-info">
                    <div class="user-name-and-user-role">
                        <p id="user-name-id">R.A.N.S. Ranasinghe</p>
                        <p id="user-name-and-role-seperator">|</p>
                        <p id="user-role-id">Admin</p>
                    </div>

                    <p>2019csxxx@stu.ucsc.lk</p>
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
            <p class="section-header-title">Collections</p>
            <a class="section-header-view-all" href="#">View All</a>
        </div>
        <div class="profile-grid">
            <div class="profile-gird-container">
                <div class="profile-grid-item  box-shadow-2">
                    <div class="profile-grid-item-icon-section">
                        <i class="fas fa-book-reader"></i>
                    </div>
                    <div class="profile-grid-item-title-section">
                        <p>Favourites</p>
                    </div>
                </div>
            </div>
            <div class="profile-gird-container">
                <div class="profile-grid-item  box-shadow-2">
                    <div class="profile-grid-item-icon-section">
                        <i class="fas fa-book-reader"></i>
                    </div>
                    <div class="profile-grid-item-title-section">
                        <p>PHP</p>
                    </div>
                </div>
            </div>
            <div class="profile-gird-container">
                <div class="profile-grid-item  box-shadow-2">
                    <div class="profile-grid-item-icon-section">
                        <i class="fas fa-book-reader"></i>
                    </div>
                    <div class="profile-grid-item-title-section">
                        <p>DSA</p>
                    </div>
                </div>
            </div>



            <div class="profile-gird-container">
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
                <div class="profile-grid-item box-shadow-2">
                    <div class="content-card ">
                        <div class="content-card-img">
                            <img src="https://m.media-amazon.com/images/I/91FlBY2B6yL._AC_UY327_FMwebp_QL65_.jpg" alt="">
                        </div>
                        <div class="content-card-bottom">
                            <p class="content-card-bottom-title line-clamp line-clamp-2-description">Learning PHP, MySQL & Javascript</p>
                        </div>
                    </div>
                </div>
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
            <p class="section-header-title">Recent Readings</p>
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
    <script src="./javascript/profile.js"></script>
</body>

</html>