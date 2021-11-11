<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />


<?php

use app\core\Application;

$user = Application::$app->user;

?>

<div class="nav">
    <div class="nav-wrapper">
        <div class="nav-logo">
            <img id="ucsc-logo" src="/../assets/nav/ucsc-logo-white.png" alt="ucsc-logo">
            <a href="/" class="nav-link" id="logo-txt">Digital Library</a>
        </div>

        <div class="nav-links">
            <div class="nav-bar-search-component-container">
                <form action="">
                    <div class="nav-bar-search-input-wrapper">
                        <input type="text" placeholder="Search">
                        <button id="nav-search-btn"><i class="fas fa-search"></i></button>
                    </div>
                </form>
            </div>
            <a class="nav-link" href="/browse">Browse</a>
            <a class="nav-link" href="#">Help</a>


            <?php

            if (!$user) {
                echo '<a id="sign-in-btn" class = "nav-link" href="/login">Sign In</a>';
                echo '<a id="sign-up-btn" class = "nav-link" href="/register">Sign Up</a>';
            } else {
                echo '<a id="notification-nav-link" href="#"><i class="fas fa-bell"></i></a>';
                echo '<div class="user-profile-circle" style="background-image: url(' . "/assets/nav/profile.jpeg" . ');"></div> ';
            }

            ?>

        </div>



        <div class="burger-menu-N-user-btn-container">

            <?php

            if (!$user) {
                echo '<a id="user-nav-link" href="./login.php"><i class="fas fa-user"></i></a>';
            } else {
                echo '<div class="user-profile-circle" style="background-image: url(' . "/assets/nav/profile.jpeg" . ');"></div> ';
            }

            ?>
            <div class="burger-menu">
                <div class="cross-line"></div>
                <div class="cross-line"></div>
                <div class="cross-line"></div>
            </div>
        </div>


    </div>

    <?php if ($user) : ?>
        <!-- <div class="overlay"></div> -->
        <div class="profile-dropdown-menu">
            <div class="user-profile-circle-dropdown-menu" style="background-image: url('/assets/nav/profile.jpeg');"></div>
            <p id="user-name"><?php
                                $userName = Application::$app->getUserDisplayName();
                                echo $userName['firstname'] . " " . $userName['lastname']; ?></p>

            <p id="user-role"><?php echo Application::$app->getUserRoleName(); ?></p>
            <div class="line-break"></div>
            <div class="dropdown-menu-links-container">
                <?php

                $currentUser_role_id = Application::$app->getUserRole();

                if ($currentUser_role_id <= 3) : ?>
                    <a href="/admin/dashboard">
                        <div class="dropdown-menu-link-item">
                            <i class="fas fa-user-shield"></i>
                            <p>Administration</p>
                        </div>
                    </a>
                <?php endif; ?>
                <a href="/profile">
                    <div class="dropdown-menu-link-item">
                        <i class="fas fa-user-circle"></i>
                        <p>My Profile</p>
                    </div>
                </a>
                <a href="/profile/my-collections">
                    <div class="dropdown-menu-link-item">
                        <i class="fas fa-sliders-h"></i>
                        <p>My Collections</p>
                    </div>
                </a>
                <a href="/logout">
                    <div class="dropdown-menu-link-item" id="link-sign-out">
                        <i class="fas fa-sign-out-alt"></i>
                        <p>Sign Out</p>
                    </div>
                </a>
            </div>
        </div>
    <?php endif; ?>


    <div class="burger-menu-slide-panel">
        <div class="burger-menu-slide-pannel-wrapper">
            <div class="search-container">
                <input class="search-input-inside-menu" type="text">
                <button class="search-btn"><i class="fas fa-search"></i></button>
            </div>
            <div class="slide-panel-links-container">
                <a href="#" class="slide-panel-link">
                    <div class="dropdown-menu-link-item">
                        <i class="far fa-folder-open"></i>
                        <p>Browse</p>
                    </div>
                </a>
                <a href="#" class="slide-panel-link">
                    <div class="dropdown-menu-link-item">
                        <i class="fas fa-search-plus"></i>
                        <p>Advanced Search</p>
                    </div>
                </a>
                <a href="#" class="slide-panel-link">
                    <div class="dropdown-menu-link-item">
                        <i class="fas fa-bell"></i>
                        <p>Notifications</p>
                    </div>
                </a>
                <a href="#" class="slide-panel-link">
                    <div class="dropdown-menu-link-item">
                        <i class="fas fa-question-circle"></i>
                        <p>Help</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>