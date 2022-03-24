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
    <link rel="stylesheet" href="./css/local-styles/get-access.css">


    <title>Document</title>
</head>

<body>

    <?php include_once __DIR__ . '/../components/nav.php'; ?>



    <?php if (isset($params['record-exists']) && $params['record-exists']) { ?>
        <p class="err-msg"><?= $params['err-msg'] ?? "" ?></p>
    <?php } ?>

    <div class="wrapper">
        <form action="#" method="POST">
            <p><?= $params['content']->title ?></p>
            <input type="hidden" name="content-id" value="<?= $params['content']->content_id ?>" />
            <select name="lend-duration">
                <option value="1">1 Week</option>
                <option value="2">2 Week</option>
                <option value="3">3 Week</option>
                <option value="4">4 Week</option>
            </select>
            <button>Request to Get Access</button>
        </form>
    </div>




    <!-- FOOTER -->

    <!-- <div class=" footer section">
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