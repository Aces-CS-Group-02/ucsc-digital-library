<?php
$isLoggedIn = true;
$userRole = "admin";
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
    <link rel="stylesheet" href="/css/local-styles/admin-create-user-group.css">

    <title>Bulk Registration</title>
</head>

<body>

    <?php
    include_once dirname(dirname(__DIR__)) . '/components/nav.php';
    ?>
    <div class="admin-dashboard-main-content">
        <div class="admin-dashboard-text">
            <p id='page-header-title'>Bulk Register</p>

            <?php include_once dirname(dirname(__DIR__)) . '/components/breadcrum.php'; ?>
        </div>
        <div class="form-container form-container-override">
            <form class="form-feature" action="" method="POST" enctype="multipart/form-data">
                <div class="input-container">
                    <div class="input-group">
                        <label class="labelPlace" for="">Upload the xls file</label>
                        <div class="custom-file custom-file-override">
                            <input class="custom-file-input" name="sheet" id="customFile" type="file" />
                            <label class="custom-file-label" for="customFile"> </label>
                        </div>
                    </div>
                    <div class="input-group">

                        <button name="file-name" value="something" class="btn btn-primary mr-1 mb-1 ">Proceed</button>

                    </div>
                </div>
            </form>
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