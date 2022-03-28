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
    <link rel="stylesheet" href="/css/local-styles/citation-history-report.css">

    <title>Citation History Report</title>
</head>

<body>
    <?php
    include_once dirname(dirname(__DIR__)) . '/components/nav.php';
    ?>

    <div class="admin-dashboard-main-content">
        <div class="admin-dashboard-text">
            <p id='page-header-title'>Citation History Report</p>

            <?php include_once dirname(dirname(__DIR__)) . '/components/breadcrum.php'; ?>
        </div>

        <?php
        $allCitationData = $params['citations'] ?? false;
        $allContentData = $params['content'] ?? false;
        // var_dump($allContentData);
        ?>

        <div class="details-container">
            <div class="data-container">
                <div class="title-container">
                    <div class="list-title">
                        Content
                    </div>
                    <div class="list-title">
                        Citation Count
                    </div>
                </div>
                <?php if ($allCitationData) { ?>
                    <?php foreach ($allCitationData as $citationData) { ?>
                        <div class="data-item-container">
                            <div class="data-item edit-data-item">
                                <?php foreach ($allContentData as $contentData) {
                                    if ($citationData->content_id == $contentData->id) { ?>
                                        <p><?= $contentData->title ?></p>
                                <?php }
                                } ?>
                            </div>
                            <div class="data-item">
                                <p><?= $citationData->count ?></p>
                            </div>
                        </div>
                <?php }
                } ?>
                <div class="data">
                    <?php if (empty($allCitationData)) { ?>
                        <div class="data-item-container">
                            <div class="data-item edit-for-no-records">
                                <p class="no-records-available">No Records Available :(</p>
                            </div>
                            <div class="data-item edit-for-no-records">
                                <p class="no-records-available">No Records Available :(</p>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>

            <div class="paginate-component-container">

                <?php


                if (!empty($allCitationData) && isset($params['pageCount'])) {
                    include_once dirname(dirname(__DIR__)) . '/components/paginate.php';
                }
                ?>
            </div>
        </div>
    </div>

    <!-- FOOTER -->

    <?php
    include_once dirname(dirname(__DIR__)) . '/components/footer.php';
    ?>

    <!-- SCRIPT -->

    <script src="/javascript/nav.js"></script>
</body>

</html>