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
    <link rel="stylesheet" href="/css/local-styles/bulk-register.css">


    <title>Bulk Registration</title>
</head>

<body>

    <!-- NAVIGATION BAR -->

    <?php
    include_once dirname(dirname(__DIR__)) . '/components/nav.php';
    ?>

    <!-- Main Content Container -->

    <div id="bulk-register-main-content">

        <div class="page-header-container">
            <p id="page-header-title">Bulk Register</p>
            <?php include_once dirname(dirname(__DIR__)) . '/components/breadcrum.php'; ?>
        </div>

        <div class="wrapper">

            <div class="second-border">

                <div class="search-N-sort-components-container">
                    <div class="search-component-container">
                        <form action="">
                            <div class="ug-search-input-wrapper">
                                <input type="text" placeholder="Search user groups">
                                <button>
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="sort-component-container">
                        <form action="">
                            <div class="input-group sort-input-edited" id="adjustments">
                                <label class="labelPlace" for="select">Sort By: </label>
                                <select class="custom-select custom-select-edited" id="select">
                                    <option value="0"></option>
                                    <option value="1">First Name</option>
                                    <option value="2">Last Name</option>
                                    <option value="3">Email</option>
                                </select>
                            </div>
                        </form>
                    </div>
                </div>

            </div>

            <form action="/admin/bulk-register/register-selected-users" method="POST">
                <!-- <input type="submit" value="test"> -->
                <!-- BULK REGISTERS INFORMATION -->

                <div class="content-container">

                    <div class="upper-container">
                        <div class="link-place">
                            <p>File Name:
                                <a href=" " class="file-name"> test.xls</a>
                            </p>
                        </div>
                        <div class="button-place">
                            <button class="btn btn-primary mr-1 mb-1" id="btn-edit" type="submit">Register</button>
                        </div>
                    </div>

                    <div class="bulk-register-headers-container">
                        <div class="block-a">First Name</div>
                        <div class="block-b">Last Name</div>
                        <div class="block-c">Email</div>
                        <div class="block-d">Action</div>
                    </div>

                    <div class="bulk-register-container">
                        <?php foreach ($params['users'] as $kay => $user) { ?>

                            <div class="bulk-register-info">
                                <input type="hidden" name="users[][first_name]" value="<?= $user->first_name; ?>">
                                <input type="hidden" name="users[][last_name]" value="<?= $user->last_name; ?>">
                                <input type="hidden" name="users[][email]" value="<?= $user->email; ?>">
                                <div class="block-a">
                                    <div class="block-title">
                                        <p>First Name</p>
                                        <p>:</p>
                                    </div>

                                    <p><?= $user->first_name; ?></p>
                                </div>
                                <div class="block-b">
                                    <div class="block-title">
                                        <p>Last Name</p>
                                        <p>:</p>
                                    </div>
                                    <p><?= $user->last_name; ?></p>

                                </div>
                                <div class="block-c">
                                    <div class="block-title">
                                        <p>Email</p>
                                        <p>:</p>
                                    </div>
                                    <p><?= $user->email; ?>
                                    <p>

                                </div>
                                <div class="block-d">
                                    <p>
                                        <button class="btn btn-danger mr-1 mb-1 btn-edit" type="button" onclick="removeRow(this)">Remove</button>
                                    </p>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>

        </div>
        </form>

    </div>
    </div>
    <script>
        function removeRow(t) {
            t.parentElement.parentElement.parentElement.remove()
        }
    </script>
    <!-- FOOTER -->

    <div class="footer-edit">
        <?php
        include_once dirname(dirname(__DIR__)) . '/components/footer.php';
        ?>
    </div>

    <!-- SCRITPT -->

    <script src="/javascript/nav.js"></script>
</body>

</html>