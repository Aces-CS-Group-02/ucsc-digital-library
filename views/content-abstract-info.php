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
    <link rel="stylesheet" href="./css/local-styles/content-abstract-info.css">


    <title>Document</title>
</head>

<body>

    <?php include_once __DIR__ . '/components/nav.php'; ?>


    <div class="wrapper">
        <div class="content-path-display">
            <p class="content-path"><?= $params['content']->path ?></p>
        </div>

        <div class="access-info-container">
            <?php if ($params['content']->permission->permission) { ?>
                <div class="access-forbidden-container">
                    <?php if ($params['content']->permission->grant_type === 'READ' || $params['content']->permission->grant_type === 'READ_DOWNLOAD') { ?>
                        <a href="/content/view?content_id=<?= $params['content']->contentInfo->content_id ?>" class='read-btn'><i class="fas fa-book-reader"></i>Read</a>
                    <?php } ?>
                    <?php if ($params['content']->permission->grant_type === 'READ_DOWNLOAD') { ?>
                        <a href="/content/view?content_id=<?= $params['content']->contentInfo->content_id ?>" class='download-btn'><i class="fas fa-download"></i>Download</a>
                    <?php } ?>
                </div>
            <?php } else { ?>
                <div class="access-forbidden-container">
                    <i class="fas fa-lock"></i>
                    <p>You can't access this content</p>
                </div>
            <?php } ?>
        </div>



        <!-- Content Items -->

        <div class="info-items-container">

            <?php $contentObj = $params['content'] ?>

            <!-- Title -->
            <div class="info-item-container first-node">
                <div class="info-item-title">
                    <p>Title:</p>
                </div>
                <div class="info-item-content">
                    <p><?= $contentObj->contentInfo->title ?></p>
                </div>
            </div>



            <!-- Authors -->
            <div class="info-item-container">
                <div class="info-item-title">
                    <p>Authors:</p>
                </div>
                <div class="info-item-content">
                    <?php
                    $authors_arr = [];
                    foreach ($contentObj->authors as $author) {
                        array_push($authors_arr, $author->creator);
                    }
                    $authors_arr = implode(' , ', $authors_arr);
                    ?>
                    <p><?= $authors_arr ?></p>
                </div>
            </div>

            <!-- Issue Date -->
            <div class="info-item-container">
                <div class="info-item-title">
                    <p>Issue Date:</p>
                </div>
                <div class="info-item-content">
                    <p><?= $contentObj->contentInfo->date ?></p>
                </div>
            </div>


            <!-- Abstract -->
            <div class="info-item-container">
                <div class="info-item-title">
                    <p>Abstract:</p>
                </div>
                <div class="info-item-content">
                    <p><?= $contentObj->contentInfo->abstract ?></p>
                </div>
            </div>

            <!-- language -->
            <div class="info-item-container">
                <div class="info-item-title">
                    <p>Language:</p>
                </div>
                <div class="info-item-content">
                    <p><?= $contentObj->language ?></p>
                </div>
            </div>

            <!-- Keywords -->
            <div class="info-item-container">
                <div class="info-item-title">
                    <p>Keywords:</p>
                </div>
                <div class="info-item-content">
                    <?php
                    $keywords_arr = [];
                    foreach ($contentObj->keywords as $keyword) {
                        array_push($keywords_arr, $keyword['keyword']);
                    }
                    $keywords_str = implode(' , ', $keywords_arr);
                    ?>
                    <p><?= $keywords_str ?></p>
                </div>
            </div>

        </div>
    </div>




    <!-- FOOTER -->

    <!-- <div class="footer section">
        <div class="wrapper">
            <div class="footer-content">
                <p>© 2021, All rights reserved by University of Colombo School of Computing <br />No: 35, Reid Avenue, Colombo 7, Sri Lanka.</p>
            </div>
        </div>
    </div> -->

    <script src="./javascript/nav.js"></script>
    <script src="./javascript/pdf-viewer.js"></script>
</body>

</html>