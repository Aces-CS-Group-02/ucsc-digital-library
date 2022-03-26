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

    <div class="admin-dashboard-main-content">
        <div class="admin-dashboard-text">
            <p id='page-header-title'>Suggested Content Report</p>
            <?php include_once dirname(dirname(__DIR__)) . '/components/breadcrum.php'; ?>
        </div>
        <div class="content-container">
            <div class="selection-division">
                <div class="input-group input-group-override">
                    <label class="labelPlace labelPlace-override" for="date">From: </label>
                    <input class="form-control" id="start-date" type="date" name="start-date"/>
                </div>
                <div class="input-group input-group-override">
                    <label class="labelPlace labelPlace-override" for="date">To: </label>
                    <input class="form-control" id="end-date" type="date" name="end-date" />
                </div>
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