<?php
$isLoggedIn = false;
$userRole = "student";
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
    <link rel="stylesheet" href="./css/local-styles/home.css">


    <title>Document</title>
</head>

<body>


    <!-- NAVIGATION BAR -->

    <?php include_once __DIR__ . '/components/nav.php'; ?>

    <!-- SEARCH CONTENT -->
    <div class="main-container">
        <div class="heading-container">
            <h2>Browse</h2>
        </div>
        <div class="left-panel-container">
            <div class="left-panel-card box-shadow-1">
                <div class="left-panel-card-title">
                    <h5>Browse menu</h5>
                </div>
                <div class="left-panel-card-item">
                    Community 1
                </div>
                <div class="left-panel-card-item">
                    Community 2
                </div>
                <div class="left-panel-card-item">
                    Community 3
                </div>
                <div class="left-panel-card-footer">
                    Community 4
                </div>
            </div>
            
        </div>
        <div class="search-result-container">
            <div class="open-side-menu">
                <button class="btn btn-light mr-1 mb-1" type="button">Show Menu</button>
            </div>
            <!-- <div class="search-result-info">
                <h6>15,000 Results for: <b>Javascript</b></h6>
                <h6>Showing 1-20 of 15,000 results | Page : 01</h6>
            </div> -->
            <div class="search-card box-shadow-1">
                <div class="search-card-img">
                    <img src="https://m.media-amazon.com/images/I/51q-bXjgtvL._SY300_.jpg" alt="" />
                </div>
                <div class="search-card-details">
                    <div class="search-card-title">
                        <h5>Title</h5>
                    </div>
                    <div class="search-card-views">
                        <h6>1.5K views . 200 Cited</h6>
                    </div>
                    <div class="search-card-creator">
                        <h6>Phu H. Phung </h6>
                    </div>
                    <div>
                        <p class="line-clamp line-clamp-x-description">The The large majority of websites nowadays embeds third-party JavaScript into their pages, coming from external partners. large majority of websites nowadays embeds third-party JavaScript into their pages, coming from external partners. …</p>
                    </div>
                    <div class="icon-bar">
                        <i class="fas fa-heart"></i>
                        <i class="fas fa-download"></i>
                        <i class="fas fa-plus"></i>
                        <i class="fas fa-quote-right"></i>
                        <i class="fas fa-share"></i>
                    </div>
                </div>

            </div>

            <div class="search-card box-shadow-1">
                <div class="search-card-img">
                    <img src="https://m.media-amazon.com/images/I/91FlBY2B6yL._AC_UY327_FMwebp_QL65_.jpg" alt="" />
                </div>
                <div class="search-card-details">
                    <div class="search-card-title">
                        <h5>Title</h5>
                    </div>
                    <div class="search-card-views">
                        <h6>1.5K views . 200 Cited</h6>
                    </div>
                    <div class="search-card-creator">
                        <h6>Phu H. Phung </h6>
                    </div>
                    <div>
                        <p class="line-clamp line-clamp-x-description">The The large majority of websites nowadays embeds third-party JavaScript into their pages, coming from external partners. large majority of websites nowadays embeds third-party JavaScript into their pages, coming from external partners. …</p>
                    </div>
                    <div class="icon-bar">
                        <i class="fas fa-heart"></i>
                        <i class="fas fa-download"></i>
                        <i class="fas fa-plus"></i>
                        <i class="fas fa-quote-right"></i>
                        <i class="fas fa-share"></i>
                    </div>
                </div>

            </div>

            <div class="search-card box-shadow-1">
                <div class="search-card-img">
                    <img src="https://m.media-amazon.com/images/I/51q-bXjgtvL._SY300_.jpg" alt="" />
                </div>
                <div class="search-card-details">
                    <div class="search-card-title">
                        <h5>Title</h5>
                    </div>
                    <div class="search-card-views">
                        <h6>1.5K views . 200 Cited</h6>
                    </div>
                    <div class="search-card-creator">
                        <h6>Phu H. Phung </h6>
                    </div>
                    <div>
                        <p class="line-clamp line-clamp-x-description">The The large majority of websites nowadays embeds third-party JavaScript into their pages, coming from external partners. large majority of websites nowadays embeds third-party JavaScript into their pages, coming from external partners. …</p>
                    </div>
                    <div class="icon-bar">
                        <i class="fas fa-heart"></i>
                        <i class="fas fa-download"></i>
                        <i class="fas fa-plus"></i>
                        <i class="fas fa-quote-right"></i>
                        <i class="fas fa-share"></i>
                    </div>
                </div>

            </div>

            <div class="search-card box-shadow-1">
                <div class="search-card-img">
                    <img src="https://m.media-amazon.com/images/I/91FlBY2B6yL._AC_UY327_FMwebp_QL65_.jpg" alt="" />
                </div>
                <div class="search-card-details">
                    <div class="search-card-title">
                        <h5>Title</h5>
                    </div>
                    <div class="search-card-views">
                        <h6>1.5K views . 200 Cited</h6>
                    </div>
                    <div class="search-card-creator">
                        <h6>Phu H. Phung </h6>
                    </div>
                    <div>
                        <p class="line-clamp line-clamp-x-description">The The large majority of websites nowadays embeds third-party JavaScript into their pages, coming from external partners. large majority of websites nowadays embeds third-party JavaScript into their pages, coming from external partners. …</p>
                    </div>
                    <div class="icon-bar">
                        <i class="fas fa-heart"></i>
                        <i class="fas fa-download"></i>
                        <i class="fas fa-plus"></i>
                        <i class="fas fa-quote-right"></i>
                        <i class="fas fa-share"></i>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <!-- FOOTER -->

    <?php include_once __DIR__ . '/components/footer.php'; ?> 

    <!-- SCRITP -->

    <script src="./javascript/nav.js"></script>
    <script src="./javascript/home.js"></script>
</body>

</html>