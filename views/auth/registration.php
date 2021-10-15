<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Global Styles -->
    <link rel="stylesheet" href="./css/global-styles/style.css" />


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Aces css framework -->
    <link rel="stylesheet" href="./css/aces-css-framework/style.css" />

    <!-- Local Styles -->
    <link rel="stylesheet" href="./css/local-styles/registration.css">

    <title>Document</title>
</head>

<body>
    <div class="main-container">
        <!-- Page left division -->
        <div class="divider-left">
            <div class="image-container"></div>
        </div>

        <!-- Page content division -->
        <div class="divider-right">

            <div class="upper-border">
                <p>Already a member?
                    <a href="/login">Sign In</a>
                </p>
            </div>

            <div class="middle-part-container">

                <div class="logo-heading-container">
                    <img id="logo-img" src="../../assets/registration/logo.png" alt="UCSC logo">
                    <div id="title">Register to UCSC <span id="break-title">Digital Library</span></div>
                </div>
                <div class="form-container">
                    <form id="form-features" action="/register" method="POST">
                        <div class="input-row-group">
                            <div class="input-group">
                                <label class="labelPlace" for="Fname">First Name</label>
                                <input class="form-control" name="first_name" id="Fname" type="text" value="<?php echo $params['model']->first_name ?>"/>
                                <?php
                                if ($params['model']->hasErrors('first_name')) {
                                    foreach ($params['model']->errors['first_name'] as $error) { ?>
                                        <div class="validation-error">
                                            <i class="fas fa-exclamation-circle"></i>
                                            <p><?php echo $error ?></p>
                                        </div>
                                <?php }
                                };
                                ?>
                            </div>
                            <div class="input-group">
                                <label class="labelPlace" for="Lname">Last Name</label>
                                <input class="form-control" name="last_name" id="Lname" type="text" value="<?php echo $params['model']->last_name ?>"/>
                                <?php
                                if ($params['model']->hasErrors('last_name')) {
                                    foreach ($params['model']->errors['last_name'] as $error) { ?>
                                        <div class="validation-error">
                                            <i class="fas fa-exclamation-circle"></i>
                                            <p><?php echo $error ?></p>
                                        </div>
                                <?php }
                                };
                                ?>
                            </div>
                        </div>
                        <div class="input-group">
                            <label class="labelPlace" for="email">Email</label>
                            <input class="form-control" name="email" id="email" type="text" value="<?php echo $params['model']->email ?>"/>
                            <?php
                                if ($params['model']->hasErrors('email')) {
                                    foreach ($params['model']->errors['email'] as $error) { ?>
                                        <div class="validation-error">
                                            <i class="fas fa-exclamation-circle"></i>
                                            <p><?php echo $error ?></p>
                                        </div>
                                <?php }
                                };
                                ?>
                        </div>
                        <div class="input-group">
                            <button class="btn btn-primary mr-1 mb-1" id="btn-edit" type="submit">
                                Register
                            </button>
                        </div>
                    </form>
                </div>

            </div>

            <div class="upper-border upper-border-in-bottom">
                <p>Already a member?
                    <a href="./login.php">Sign In</a>
                </p>
            </div>

        </div>
    </div>
</body>

</html>