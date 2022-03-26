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

    <div class="heading-container">
    </div>
    <div class="main-container">
        <div class="wrapper">
            <?php include_once dirname(__DIR__) . '/views/components/breadcrum-v2.php'; ?>

            <h1>Top Level Communities of UCSC Digital Library</h1>
            <div class="sub-communities-inner-container">
                <?php foreach ($params['topLevelCommunities'] as $toplevelcommunity) { ?>
                    <div class="collection-data-row">
                        <a href="/browse/community?community_id=<?= $toplevelcommunity->community_id ?>"><?= $toplevelcommunity->name ?></a>
                        <?php if (Application::$app->getUserRole() <= 2) { ?>
                            <form action="/admin/delete-community" method="POST" onclick="return confirm('Are you sure?')">
                                <input type="hidden" name="redirect-parent" value="<?= $params['redirect-parent'] ?>" />
                                <button class="delete-btn" name="community-id" value="<?= $toplevelcommunity->community_id ?>">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>

    <!-- FOOTER -->
    <?php include_once __DIR__ . '/components/footer.php'; ?>

    <!-- SCRITPT -->
    <script src="./javascript/nav.js"></script>
    <script src="./javascript/alert.js"></script>
</body>

</html>