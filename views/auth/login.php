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
    <link rel="stylesheet" href="./css/local-styles/login.css">

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
                <p>Not a member?
                    <a href="/register">Register Now</a>
                </p>
            </div>

            <div class="middle-part-container">

                <div class="logo-heading-container">
                    <img id="logo-img" src="../../assets/login/logo.png" alt="UCSC logo">
                    <div id="title">Sign In to UCSC <span id="break-title">Digital Library</span></div>
                </div>
                <div class="form-container">
                    <form id="form-features" action="/login" method="POST">
                        <div class="input-group">
                            <label class="labelPlace" for="email">Email</label>
                            <input class="form-control" name="email" id="email" type="text" />
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
                            <div id="align-vertical">
                                <label class="labelPlace" for="password">Password</label>
                                <a href="./forgot-password">Forgot Password?</a>
                            </div>
                            <div class="form-password">
                                <input class="inputStyle" id="password" name="password" type="password" />
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
                        <div class="input-group custom-control">
                            <div class="checkbox">
                                <input type="checkbox" />
                                <p>Remember Me</p>
                            </div>
                        </div>
                        <div class="input-group">
                            <button class="btn btn-primary mr-1 mb-1" id="btn-edit" type="submit">
                                Sign In
                            </button>
                        </div>
                    </form>
                </div>

            </div>

            <div class="upper-border upper-border-in-bottom">
                <p>Not a member?
                    <a href="./registration.php">Register Now</a>
                </p>
            </div>

        </div>
    </div>

    <!-- SCRITPT -->
    <script src="./javascript/login.js"></script>
</body>

</html>