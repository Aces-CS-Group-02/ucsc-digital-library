<?php

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
    <link rel="stylesheet" href="/css/global-styles/paginate.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Aces css framework -->
    <link rel="stylesheet" href="/css/aces-css-framework/style.css">

    <!-- Local Styles -->
    <!-- <link rel="stylesheet" href="/css/local-styles/search.css"> -->
    <link rel="stylesheet" href="/css/local-styles/browse-communities-and-collections.css">


    <title>Browse Content</title>
</head>

<body>
    <!-- NAVIGATION BAR -->
    <?php include_once __DIR__ . '/components/nav.php'; ?>

    <!-- SEARCH CONTENT -->
    <div class="heading-container">
        <!-- Browse -->
    </div>
    <div class="main-container">
        <div class="wrapper">
            <!-- <div class='browse-breadcrumb-container'> -->
            <?php include_once dirname(__DIR__) . '/views/components/breadcrum-v2.php'; ?>
            <!-- </div> -->


            <h1><?= $params['selected-item']->name ?></h1>

            <?php if ($params['type'] == 'collection') { ?>
                <p class='type-text'>Collection</p>
            <?php } else if ($params['type'] == 'community') { ?>
                <p class='type-text'>Community</p>
            <?php } ?>

            <p class='description-text'><?= $params['selected-item']->description ?></p>

            <p class='browse-by-text'>Browse by </p>
            <div class="filters-container">

                <?php if ($params['type'] == 'community') { ?>
                    <a class='browse-filter' href="/browse?community=<?= $params['selected-item']->community_id ?>&type=dateissued">Date issued</a>
                    <a class='browse-filter' href="/browse?community=<?= $params['selected-item']->community_id ?>&type=title">Title</a>
                <?php } else if ($params['type'] == 'collection') { ?>
                    <a class='browse-filter' href="/browse?collection=<?= $params['selected-item']->collection_id ?>&type=dateissued">Date issued</a>
                    <a class='browse-filter' href="/browse?collection=<?= $params['selected-item']->collection_id ?>&type=title">Title</a>
                <?php } ?>
            </div>


            <?php if ($params['type'] == 'community') { ?>
                <!-- sub communities list -->
                <?php if ($params['communities_of_dir']) { ?>
                    <div class="communities-container">
                        <p class='sub-community-title'>Sub communities</p>
                        <div class='sub-communities-inner-container'>
                            <?php foreach ($params['communities_of_dir'] as $community) { ?>
                                <a href="/browse/community?community_id=<?= $community->community_id ?>"><?= $community->name ?></a>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>

                <!-- Collections list -->
                <?php if ($params['collections_of_dir']) { ?>
                    <div class="collections-container">
                        <p class='collection-title'>Collections</p>
                        <div class="collections-inner-container">
                            <?php foreach ($params['collections_of_dir'] as $collection) { ?>
                                <a href="/browse/collection?collection_id=<?= $collection['collection_id'] ?>"><?= $collection['name'] ?></a>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>
    </div>

    <!-- FOOTER -->

    <?php include_once __DIR__ . '/components/footer.php'; ?>

    <!-- SCRITPT -->

    <script src="./javascript/nav.js"></script>
    <script src="./javascript/alert.js"></script>

</body>

</html>