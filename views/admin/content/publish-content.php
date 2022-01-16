<?php
$isLoggedIn = true;
$userRole = "student";
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
    <link rel="stylesheet" href="/css/global-styles/paginate.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Aces css framework -->
    <link rel="stylesheet" href="/css/aces-css-framework/style.css">

    <!-- Local Styles -->
    <link rel="stylesheet" href="/css/local-styles/publish-content.css">




    <title>Publish Content</title>
</head>

<body>

    <!-- NAVIGATION BAR -->

    <?php
    include_once dirname(dirname(__DIR__)) . '/components/nav.php';
    ?>


    <!-- Main Content Container -->

    <div id="publish-content-main-content">
        <div class="page-header-container">
            <p id="page-header-title">Publish Content</p>
            <?php include_once dirname(dirname(__DIR__)) . '/components/breadcrum.php'; ?>
        </div>

        <div class="wrapper">
            <div class="second-border">
                <!-- Flash Message -->
                <?php

                use app\core\Application;

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

                <?php


                if (Application::$app->session->getFlashMessage('error')) { ?>


                    <div class="alert alert-success" id="flash-msg-alert">
                        <strong>Success!</strong>

                        <?php echo Application::$app->session->getFlashMessage('error'); ?>

                        <button class="close" type="button" id="flash-msg-remove">
                            <span class="font-weight-light"></span>
                            <i class="fas fa-times icon-sucess" style="font-size: 0.73em"></i>
                        </button>
                    </div>


                <?php } ?>
            </div>

            <div class="search-N-sort-components-container">
                <div class="search-component-container">
                    <form action="" method="GET">
                        <div class="ug-search-input-wrapper">
                            <input type="text" placeholder="Search content by title" name='q' value="<?php echo $params['search_params'] ?? '' ?>">
                            <button>
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
                <div class="sort-component-container">
                    <form action="">
                        <div class="input-group sort-input-edited" id="adjustments">
                            <label class="labelPlace" for="select">Sort By: </label>
                            <select class="custom-select custom-select-edited" id="select">
                                <option value="0"></option>
                                <option value="1">Title</option>
                                <option value="2">Creator</option>
                                <option value="3">Type</option>
                                <option value="4">Date</option>
                            </select>
                        </div>
                    </form>
                </div>
            </div>

            <div class="a-to-z-sort-main-container">
                <p id="a-to-z-sort-name">Title: </p>
                <div class="a-to-z-sort-component-container">
                    <button class="a-to-z-sort-btn a-to-z-all-btn selected">All</button>
                    <button class="a-to-z-sort-btn">A</button>
                    <button class="a-to-z-sort-btn">B</button>
                    <button class="a-to-z-sort-btn">C</button>
                    <button class="a-to-z-sort-btn">D</button>
                    <button class="a-to-z-sort-btn">E</button>
                    <button class="a-to-z-sort-btn">F</button>
                    <button class="a-to-z-sort-btn">G</button>
                    <button class="a-to-z-sort-btn">H</button>
                    <button class="a-to-z-sort-btn">I</button>
                    <button class="a-to-z-sort-btn">J</button>
                    <button class="a-to-z-sort-btn">K</button>
                    <button class="a-to-z-sort-btn">L</button>
                    <button class="a-to-z-sort-btn">M</button>
                    <button class="a-to-z-sort-btn">N</button>
                    <button class="a-to-z-sort-btn">O</button>
                    <button class="a-to-z-sort-btn">P</button>
                    <button class="a-to-z-sort-btn">Q</button>
                    <button class="a-to-z-sort-btn">R</button>
                    <button class="a-to-z-sort-btn">S</button>
                    <button class="a-to-z-sort-btn">T</button>
                    <button class="a-to-z-sort-btn">U</button>
                    <button class="a-to-z-sort-btn">V</button>
                    <button class="a-to-z-sort-btn">W</button>
                    <button class="a-to-z-sort-btn">X</button>
                    <button class="a-to-z-sort-btn">Y</button>
                    <button class="a-to-z-sort-btn">Z</button>

                </div>
            </div>

            <div class="a-to-z-sort-main-container second">
                <p id="a-to-z-sort-name">Creator: </p>
                <div class="a-to-z-sort-component-container">
                    <button class="a-to-z-sort-btn a-to-z-all-btn selected">All</button>
                    <button class="a-to-z-sort-btn">A</button>
                    <button class="a-to-z-sort-btn">B</button>
                    <button class="a-to-z-sort-btn">C</button>
                    <button class="a-to-z-sort-btn">D</button>
                    <button class="a-to-z-sort-btn">E</button>
                    <button class="a-to-z-sort-btn">F</button>
                    <button class="a-to-z-sort-btn">G</button>
                    <button class="a-to-z-sort-btn">H</button>
                    <button class="a-to-z-sort-btn">I</button>
                    <button class="a-to-z-sort-btn">J</button>
                    <button class="a-to-z-sort-btn">K</button>
                    <button class="a-to-z-sort-btn">L</button>
                    <button class="a-to-z-sort-btn">M</button>
                    <button class="a-to-z-sort-btn">N</button>
                    <button class="a-to-z-sort-btn">O</button>
                    <button class="a-to-z-sort-btn">P</button>
                    <button class="a-to-z-sort-btn">Q</button>
                    <button class="a-to-z-sort-btn">R</button>
                    <button class="a-to-z-sort-btn">S</button>
                    <button class="a-to-z-sort-btn">T</button>
                    <button class="a-to-z-sort-btn">U</button>
                    <button class="a-to-z-sort-btn">V</button>
                    <button class="a-to-z-sort-btn">W</button>
                    <button class="a-to-z-sort-btn">X</button>
                    <button class="a-to-z-sort-btn">Y</button>
                    <button class="a-to-z-sort-btn">Z</button>

                </div>
            </div>


            <!-- PUBLISH CONTENT INFORMATION -->

            <div class="content-container">

                <div class="publish-contents-headers-container">
                    <div class="block-a">Title</div>
                    <div class="block-b">Creator</div>
                    <div class="block-d">Date</div>
                    <div class="block-e">Action</div>

                </div>

                <div class="publish-content-container">
                    <?php foreach ($params['content'] as $content) { ?>
                        <div class="publish-content-info">
                            <div class="block-a">
                                <div class="block-title">
                                    <p>Title</p>
                                    <p>:</p>
                                </div>
                                <p><?php echo $content->title; ?></p>
                            </div>

                            <div class="block-b">
                                <div class="block-title">
                                    <p>Creator</p>
                                    <p>:</p>
                                </div>
                                <p><?php
                                    echo $content->creators[0]['creator']; //ask
                                    for ($i = 1; $i < count($content->creators); $i++) {
                                        echo ', ' . $content->creators[$i]['creator'];
                                    } ?></p>
                            </div>
                            <div class="block-d">
                                <div class="block-title">
                                    <p>Date</p>
                                    <p>:</p>
                                </div>
                                <p><?php $date = new DateTime($content->date);
                                    echo $date->format('Y-m-d'); ?></p>
                            </div>
                            <div class="block-e">
                                <p>
                                <form action="/admin/publish-content/view" method="GET">
                                    <button class="btn btn-info mr-1 mb-1 btn1-edit" type="submit" name="content_id" value="<?php echo $content->content_id; ?>">View</button>
                                </form>
                                <form action="/admin/publish-content/publish" method="POST">
                                    <button class="btn btn-danger mr-1 mb-1 btn-edit" onclick="confirm('Are you sure?')" name="content_id" value="<?= $content->content_id ?>">Publish</button>
                                </form>
                                </p>
                            </div>
                        </div>
                    <?php } ?>

                    <?php if (empty($params['content'])) { ?>
                        <p class="no-records-available">No Records Available :(</p>
                    <?php } ?>
                    <?php

                    if (!empty($params['content']) && isset($params['pageCount'])) {
                        include_once dirname(dirname(__DIR__)) . '/components/paginate.php';
                    }
                    ?>

                </div>

            </div>

        </div>

    </div>

    <!-- FOOTER -->

    <?php
    include_once dirname(dirname(__DIR__)) . '/components/footer.php';
    ?>
    <script src="/javascript/nav.js"></script>

</body>

</html>