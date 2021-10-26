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
                    <form id="form-features" action="/registration-request" method="POST" enctype="multipart/form-data">
                        <div class="input-row-group">
                            <div class="input-group">
                                <label class="labelPlace <?php if ($params['model']->hasErrors('first_name')) {
                                                                echo "danger-text";
                                                            } ?>" for="Fname">First Name</label>
                                <input class="form-control <?php if ($params['model']->hasErrors('password')) {
                                                                echo "danger-border";
                                                            } ?>" name="first_name" id="Fname" type="text" value="<?php echo $params['model']->first_name ?>" readonly="readonly" />
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
                                <label class="labelPlace <?php if ($params['model']->hasErrors('last_name')) {
                                                                echo "danger-text";
                                                            } ?>" for="Lname">Last Name</label>
                                <input class="form-control <?php if ($params['model']->hasErrors('last_name')) {
                                                                echo "danger-border";
                                                            } ?>" name="last_name" id="Lname" type="text" value="<?php echo $params['model']->last_name ?>" readonly="readonly" />
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
                            <label class="labelPlace <?php if ($params['model']->hasErrors('email')) {
                                                            echo "danger-text";
                                                        } ?>" for="email">Email</label>
                            <input class="form-control <?php if ($params['model']->hasErrors('email')) {
                                                            echo "danger-border";
                                                        } ?>" name="email" id="email" type="text" value="<?php echo $params['model']->email ?>" readonly="readonly" />
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
                        <div class="input-row-group">
                            <div class="input-group" id="adjustments">
                                <label class="labelPlace <?php if ($params['model']->hasErrors('verification')) {
                                                                echo "danger-text";
                                                            } ?>" for="file">Attach NIC image</label>
                                <div class="custom-file <?php if ($params['model']->hasErrors('verification')) {
                                                            echo "danger-border";
                                                        } ?>" id="file">
                                    <input class="custom-file-input" name="verification" id="customFile" type="file" />
                                    <label class="custom-file-label" for="customFile"> </label>
                                </div>
                                <?php
                                if ($params['model']->hasErrors('verification')) {
                                    foreach ($params['model']->errors['verification'] as $error) { ?>
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
                            <label class="labelPlace <?php if ($params['model']->hasErrors('message')) {
                                                            echo "danger-text";
                                                        } ?>" for="message">Message</label>
                            <textarea class="form-control <?php if ($params['model']->hasErrors('message')) {
                                                            echo "danger-text";
                                                        } ?>" name="message" id="message"></textarea>
                            <?php
                            if ($params['model']->hasErrors('message')) {
                                foreach ($params['model']->errors['message'] as $error) { ?>
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