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
    <link rel="stylesheet" href="/css/local-styles/suggested-content-report.css">

    <title>Suggested Content Report</title>
</head>

<body>
    <?php
    include_once dirname(dirname(__DIR__)) . '/components/nav.php';
    ?>

    <?php

    $contentSuggestionsData = $params['contentSuggestions'] ?? false;
    $userData = $params['users'] ?? false;
    $errorMsg = $params['error'] ?? false;
    $error = $params['errorMsg'] ?? "";

    // if ($errorMsg) {
    //     echo '<script type="text/javascript src="/javascript/suggested-content-report.js"">',
    //     'displayError();',
    //     '</script>';
    // }
    // echo $error;
    ?>

    <div class="admin-dashboard-main-content">
        <div class="admin-dashboard-text">
            <p id='page-header-title'>Suggested Content Report</p>
            <?php include_once dirname(dirname(__DIR__)) . '/components/breadcrum.php'; ?>
        </div>
        <div class="content-container">
            <div class="selection-division-container">
                <form class="selection-division" action="/admin/suggested-content-report" method="POST">
                    <div class="input-group input-group-override">
                        <label class="labelPlace labelPlace-override" for="date">From: </label>
                        <div style="display: flex; flex-direction: column">
                            <input class="form-control edit-form-conrol <?php if ($errorMsg && ($error == "start" || $error == "both")) echo 'add-error' ?>" id="start-date" type="date" name="start-date" />
                            <label class="error-text <?php if ($errorMsg && ($error == "start" || $error == "both")) echo 'show-text' ?>">This field can't be empty</label>
                        </div>
                    </div>
                    <div class="input-group input-group-override">
                        <label class="labelPlace labelPlace-override" for="date">To: </label>
                        <div style="display: flex; flex-direction: column">
                            <input class="form-control edit-form-conrol <?php if ($errorMsg && ($error == "end" || $error == "both")) echo 'add-error' ?>" id="end-date" type="date" name="end-date" onselect="getData(this)" />
                            <label class="error-text <?php if ($errorMsg && ($error == "end" || $error == "both")) echo 'show-text' ?>">This field can't be empty</label>
                        </div>
                    </div>
                    <div class="input-group edit-input-group">
                        <button class="btn btn-primary btn-edit" type="submit">Go</button>
                    </div>
                </form>
            </div>
        </div>



        <div class="details-container">
            <div class="data-container">
                <div class="title-container">
                    <div class="list-title">
                        Title
                    </div>
                    <div class="list-title">
                        Creator
                    </div>
                    <div class="list-title">
                        ISBN
                    </div>
                    <div class="list-title">
                        Information
                    </div>
                    <div class="list-title">
                        Requested User
                    </div>
                </div>
                <?php if ($contentSuggestionsData) { ?>
                    <?php foreach ($contentSuggestionsData as $data) { ?>
                        <div class="data-item-container">
                            <div class="data-item">
                                <p><?= $data->title ?></p>
                            </div>
                            <div class="data-item">
                                <p><?= $data->creator ?></p>
                            </div>
                            <?php if ($data->isbn) { ?>
                                <div class="data-item">
                                    <p><?= $data->isbn ?></p>
                                </div>
                            <?php } else { ?>
                                <div class="data-item">
                                    <p class="n-a">N/A</p>
                                </div>
                            <?php } ?>
                            <?php if ($data->information) { ?>
                                <div class="data-item">
                                    <p><?= $data->information ?></p>
                                </div>
                            <?php } else { ?>
                                <div class="data-item">
                                    <p class="n-a">N/A</p>
                                </div>
                            <?php } ?>
                            <div class="data-item">
                                <?php foreach ($userData as $uData) {
                                    if ($data->reg_no == $uData->id) { ?>
                                        <p><?= $uData->name ?></p>
                                <?php break;
                                    }
                                } ?>
                            </div>
                        </div>
                    <?php } ?>
                <?php } ?>
                <div class="data">
                    <?php if (empty($contentSuggestionsData)) { ?>
                        <!-- <div class="data-item-container"> -->
                        <!-- <div class="data-item edit-for-no-records">
                                <p class="no-records-available">No Records Available :(</p>
                            </div> -->
                        <div class="data-item edit-for-no-records">
                            <p class="no-records-available">No Records Available :(</p>
                        </div>
                        <!-- </div> -->
                    <?php } ?>
                </div>
            </div>
            <div class="paginate-component-container">
                <?php
                if (!empty($contentSuggestionsData) && isset($params['pageCount'])) {
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