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

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Aces css framework -->
    <link rel="stylesheet" href="/css/aces-css-framework/style.css">

    <!-- Local Styles -->
    <link rel="stylesheet" href="/css/local-styles/admin-bulk-upload.css">



    <title>Document</title>
</head>

<body>

    <!-- NAVIGATION BAR -->

    <?php
    include_once dirname(dirname(__DIR__)) . '/components/nav.php';
    ?>

    <!-- Main Content Container -->
    <div class="admin-dashboard-main-content">
        <div class="admin-dashboard-text">
            <p id="page-header-title">Bulk Upload Content</p>
            <?php include_once dirname(dirname(__DIR__)) . '/components/breadcrum.php'; ?>
        </div>
        <div class="form-container form-container-override">
            <form class="form-feature">
                <div class="input-container">
                    <div class="input-group">
                        <label class="labelPlace" for="">Upload the xls files</label>
                        <div class="custom-file custom-file-override">
                            <input class="custom-file-input" id="customFile" type="file" />
                            <label class="custom-file-label" for="customFile"> </label>
                        </div>
                    </div>
                    <div class="input-group">
                        <button class="btn btn-primary mr-1 mb-1 " type="button">Proceed</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <!-- FOOTER -->

    <?php
    include_once dirname(dirname(__DIR__)) . '/components/footer.php';
    ?>
    <script src="./javascript/nav.js"></script>
</body>

</html>