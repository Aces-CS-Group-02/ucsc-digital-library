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
    <link rel="stylesheet" href="/css/global-styles/style.css">
    <link rel="stylesheet" href="/css/global-styles/nav.css">
    <link rel="stylesheet" href="/css/global-styles/footer.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Aces css framework -->
    <link rel="stylesheet" href="/css/aces-css-framework/style.css">

    <!-- Local Styles -->
    <link rel="stylesheet" href="/css/local-styles/registration-successful.css">


    <title>Document</title>
</head>

<body>
    <!-- NAVIGATION BAR -->
    <?php include_once dirname(__DIR__) . '/components/nav.php'; ?>

    <div class="error-content-container">



        <div class="error-bg-img">
            <div class="error-img" style="background-image: url('/assets/registration/success.svg');"></div>
        </div>

        <div class="error-content">
            <p class="error-msg">Thanks for registering, verification email sent, check your emails :)</p>
        </div>

    </div>

    <script src="/javascript/nav.js"></script>

</body>

</html>