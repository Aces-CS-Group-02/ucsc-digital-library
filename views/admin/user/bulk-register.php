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


    <title>Document</title>
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

                <div class="upper-container">
                    <div class="link-place">
                        <p>File Name:
                            <a href=" " class="file-name"> test.xls</a>
                        </p>
                    </div>
                    <div class="button-place">
                        <button class="btn btn-primary mr-1 mb-1" id="btn-edit" type="button">Register</button>
                    </div>
                </div>

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

            <!-- BULK REGISTERS INFORMATION -->

            <div class="content-container">

                <div class="bulk-register-headers-container">
                    <div class="block-a">First Name</div>
                    <div class="block-b">Last Name</div>
                    <div class="block-c">Email</div>
                    <div class="block-d">Action</div>
                </div>

                <div class="bulk-register-container">
                    <div class="bulk-register-info">
                        <div class="block-a">
                            <div class="block-title">
                                <p>First Name</p>
                                <p>:</p>
                            </div>
                            <p>Phu</p>
                        </div>
                        <div class="block-b">
                            <div class="block-title">
                                <p>Last Name</p>
                                <p>:</p>
                            </div>
                            <p>Phang</p>
                        </div>
                        <div class="block-c">
                            <div class="block-title">
                                <p>Email</p>
                                <p>:</p>
                            </div>
                            <p>phuphang@stu.ucsc.lk</p>
                        </div>
                        <div class="block-d">
                            <p>
                                <button class="btn btn-danger mr-1 mb-1 btn-edit" type="button">Remove</button>
                            </p>
                        </div>
                    </div>
                    <div class="bulk-register-info">
                        <div class="block-a">
                            <div class="block-title">
                                <p>First Name</p>
                                <p>:</p>
                            </div>
                            <p>Phu</p>
                        </div>
                        <div class="block-b">
                            <div class="block-title">
                                <p>Last Name</p>
                                <p>:</p>
                            </div>
                            <p>Phang</p>
                        </div>
                        <div class="block-c">
                            <div class="block-title">
                                <p>Email</p>
                                <p>:</p>
                            </div>
                            <p>phuphang@stu.ucsc.lk</p>
                        </div>
                        <div class="block-d">
                            <p>
                                <button class="btn btn-danger mr-1 mb-1 btn-edit" type="button">Remove</button>
                            </p>
                        </div>
                    </div>
                    <div class="bulk-register-info">
                        <div class="block-a">
                            <div class="block-title">
                                <p>First Name</p>
                                <p>:</p>
                            </div>
                            <p>Phu</p>
                        </div>
                        <div class="block-b">
                            <div class="block-title">
                                <p>Last Name</p>
                                <p>:</p>
                            </div>
                            <p>Phang</p>
                        </div>
                        <div class="block-c">
                            <div class="block-title">
                                <p>Email</p>
                                <p>:</p>
                            </div>
                            <p>phuphang@stu.ucsc.lk</p>
                        </div>
                        <div class="block-d">
                            <p>
                                <button class="btn btn-danger mr-1 mb-1 btn-edit" type="button">Remove</button>
                            </p>
                        </div>
                    </div>
                    <div class="bulk-register-info">
                        <div class="block-a">
                            <div class="block-title">
                                <p>First Name</p>
                                <p>:</p>
                            </div>
                            <p>Phu</p>
                        </div>
                        <div class="block-b">
                            <div class="block-title">
                                <p>Last Name</p>
                                <p>:</p>
                            </div>
                            <p>Phang</p>
                        </div>
                        <div class="block-c">
                            <div class="block-title">
                                <p>Email</p>
                                <p>:</p>
                            </div>
                            <p>phuphang@stu.ucsc.lk</p>
                        </div>
                        <div class="block-d">
                            <p>
                                <button class="btn btn-danger mr-1 mb-1 btn-edit" type="button">Remove</button>
                            </p>
                        </div>
                    </div>
                    <div class="bulk-register-info">
                        <div class="block-a">
                            <div class="block-title">
                                <p>First Name</p>
                                <p>:</p>
                            </div>
                            <p>Phu</p>
                        </div>
                        <div class="block-b">
                            <div class="block-title">
                                <p>Last Name</p>
                                <p>:</p>
                            </div>
                            <p>Phang</p>
                        </div>
                        <div class="block-c">
                            <div class="block-title">
                                <p>Email</p>
                                <p>:</p>
                            </div>
                            <p>phuphang@stu.ucsc.lk</p>
                        </div>
                        <div class="block-d">
                            <p>
                                <button class="btn btn-danger mr-1 mb-1 btn-edit" type="button">Remove</button>
                            </p>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>

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