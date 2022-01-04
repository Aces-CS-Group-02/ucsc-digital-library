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
    <link rel="stylesheet" href="./css/global-styles/paginate.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Aces css framework -->
    <link rel="stylesheet" href="./css/aces-css-framework/style.css">

    <!-- Local Styles -->
    <link rel="stylesheet" href="./css/local-styles/search.css">
    <link rel="stylesheet" href="./css/local-styles/home.css">


    <title>Browse Content</title>
</head>

<body>
    <!-- NAVIGATION BAR -->
    <?php include_once __DIR__ . '/components/nav.php'; ?>

    <!-- SEARCH CONTENT -->
    <div class="heading-container">
        Browse
    </div>
    <div class="main-container">


        <div class="wrapper">

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

            <div class="filters-container">
                <?php if ($params['type'] === 'dateissued') { ?>
                    <p>Browse By Date Issued</p>
                    <form action="" method="GET">
                        <input type="hidden" name='type' value='dateissued' />
                        <label>Choose Year</label>
                        <select name="year">
                            <option selected="selected" value="-1">Select a year</option>
                            <?php for ($i = 1950; $i <= (int)date("Y"); $i++) { ?>
                                <option value="<?= $i ?>"><?= $i ?></option>
                            <?php } ?>
                        </select>


                        <label>Choose Year</label>
                        <select name="month">
                            <option selected="selected" value="-1">Select a month</option>
                            <?php for ($i = 1; $i <= 12; $i++) { ?>
                                <option value="<?= $i ?>"><?php
                                                            $monthName = date("F", mktime(0, 0, 0, $i, 10));
                                                            echo $monthName;
                                                            ?></option>
                            <?php } ?>
                        </select>

                        <label>In Order</label>
                        <select name="order">
                            <option value="DESC">DESC</option>
                            <option value="ASC">ASC</option>
                        </select>


                        <label>Result per page</label>
                        <select name="rpp">
                            <?php for ($i = 5; $i <= 100; $i += 5) { ?>
                                <option <?php if ($i == 20) {
                                            echo "selected='selected'";
                                        } ?> value="<?= $i ?>"><?= $i ?></option>



                            <?php } ?>
                        </select>

                        <button>GO</button>
                    </form>
                <?php } ?>


                <?php if ($params['type'] === 'title') { ?>
                    <p>Browse By Title</p>
                    <form action="" method="GET">
                        <input type="hidden" name='type' value='title' />

                        <select name="starts_with">
                            <option selected="selected" value="-1">Starts with</option>
                            <option value="100">0-9</option>
                            <?php for ($i = 65; $i <= 91; $i++) { ?>
                                <option value="<?= $i ?>"><?php echo chr($i) ?></option>
                            <?php } ?>
                        </select>


                        <label>In Order</label>
                        <select name="order">
                            <option value="ASC">ASC</option>
                            <option value="DESC">DESC</option>
                        </select>


                        <label>Result per page</label>
                        <select name="rpp">
                            <?php for ($i = 5; $i <= 100; $i += 5) { ?>
                                <option <?php if ($i == 20) {
                                            echo "selected='selected'";
                                        } ?> value="<?= $i ?>"><?= $i ?></option>



                            <?php } ?>
                        </select>

                        <button>GO</button>
                    </form>
                <?php } ?>


            </div>

            <div class="result-container">

                <?php foreach ($params['data'] as $result) { ?>
                    <div class="search-card box-shadow-1">
                        <div class="search-card-img">
                            <img src="https://m.media-amazon.com/images/I/91FlBY2B6yL._AC_UY327_FMwebp_QL65_.jpg" alt="" />
                        </div>
                        <div class="search-card-details">
                            <div class="search-card-title">
                                <a href="/content?content_id=<?= $result->content_id ?>">
                                    <h5><?= $result->title ?></h5>
                                </a>
                            </div>
                            <div class="search-card-views">
                                <h6>1.5K views . 200 Cited</h6>
                            </div>
                            <div class="search-card-creator">
                                <h6>
                                    <?= $result->creators ?>
                                </h6>
                            </div>
                            <div>
                                <p class="line-clamp line-clamp-x-description"><?= $result->abstract ?></p>
                            </div>
                            <div class="icon-bar">
                                <i class="fas fa-heart" data-id="<?= $result->content_id ?>"></i>
                                <i class="fas fa-download"></i>
                                <i class="fas fa-plus"></i>
                                <i class="fas fa-quote-right"></i>
                                <i class="fas fa-share"></i>
                            </div>
                        </div>

                    </div>
                <?php } ?>
            </div>
        </div>
    </div>

    <?php if ($params['data']) { ?>
        <?php include_once __DIR__ . '/components/paginate.php'; ?>
    <?php } else { ?>
        No Entries
    <?php } ?>


    <!-- FOOTER -->

    <?php include_once __DIR__ . '/components/footer.php'; ?>

    <!-- SCRITPT -->

    <script src="./javascript/nav.js"></script>
    <script src="./javascript/alert.js"></script>

</body>

</html>