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
    <link rel="stylesheet" href="./css/local-styles/forgot-password.css">

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

            <!-- <div class="upper-border">
                <p>Not a member?
                    <a href="/register">Register Now</a>
                </p>
            </div> -->

            <div class="middle-part-container">

                <div class="logo-heading-container">
                    <img id="logo-img" src="../../assets/login/logo.png" alt="UCSC logo">
                    <div id="title">Reset Password</div>
                </div>
                <div class="form-container">
                    <form id="form-features" action="/reset-password" method="POST">
                        <div class="input-group" id="adjust-align">
                            <p>
                                Enter your new password...
                            </p>
                        </div>
                        <input type="hidden" name="token" value="<?php echo $params['model']->token?>">

                        <input type="hidden" name="email" value="<?php echo $params['model']->email?>">

                        <div class="input-group">
                            <div id="align-vertical">
                                <label class="labelPlace <?php if ($params['model']->hasErrors('password')) {
                                                                echo "danger-text";
                                                            } ?>" for="password">Password</label>
                            </div>
                            <div class="form-password <?php if ($params['model']->hasErrors('password')) {
                                                                echo "danger-border";
                                                            } ?>">
                                <input class="inputStyle" name="password" id="password" type="password" />
                                <button id="hide-btn" type="button">
                                    <i class="fas fa-eye-slash"></i>
                                </button>
                            </div>
                            <?php
                            if ($params['model']->hasErrors('password')) {
                                foreach ($params['model']->errors['password'] as $error) { ?>
                                    <div class="validation-error">
                                        <i class="fas fa-exclamation-circle"></i>
                                        <p><?php echo $error ?></p>
                                    </div>
                            <?php }
                            };
                            ?>
                        </div>
                        <div class="input-group">
                            <div id="align-vertical">
                                <label class="labelPlace <?php if ($params['model']->hasErrors('confirm_password')) {
                                                                echo "danger-text";
                                                            } ?>" for="confirm_password">Confirm password</label>
                            </div>
                            <div class="form-password <?php if ($params['model']->hasErrors('confirm_password')) {
                                                                echo "danger-border";
                                                            } ?>">
                                <input class="inputStyle" id="confirm_password" name="confirm_password" type="password" />
                                <button id="hide-btn" type="button">
                                    <i class="fas fa-eye-slash"></i>
                                </button>
                            </div>
                            <?php
                            if ($params['model']->hasErrors('confirm_password')) {
                                foreach ($params['model']->errors['confirm_password'] as $error) { ?>
                                    <div class="validation-error">
                                        <i class="fas fa-exclamation-circle"></i>
                                        <p><?php echo $error ?></p>
                                    </div>
                            <?php }
                            };
                            ?>
                        </div>
                        <div class="input-group" id="adjust-button-align">
                            <button class="btn btn-primary mr-1 mb-1" id="btn-edit" type="submit">
                                Send
                            </button>
                        </div>
                    </form>
                </div>

            </div>

            <div class="upper-border upper-border-in-bottom">
                <p>Not a member?
                    <a href="/register">Register Now</a>
                </p>
            </div>

        </div>
    </div>

    <!-- SCRITPT -->
    <script src="./javascript/login.js"></script>
</body>

</html>