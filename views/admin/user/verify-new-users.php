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
    <link rel="stylesheet" href="/css/local-styles/verify-new-users.css">


    <title>Document</title>
</head>

<body>

    <!-- NAVIGATION BAR -->

    <?php
    include_once dirname(dirname(__DIR__)) . '/components/nav.php';
    ?>

    <!-- VERIFY NEW USERS PAGE -->

    <div class="page-header-container">
        <p id="page-header-title">Verify New Users</p>
    </div>

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
                            <option value="1">Registered Date</option>
                            <option value="2">User Email</option>
                            <option value="3">Name</option>
                        </select>
                    </div>
                </form>
            </div>
        </div>

        <div class="button-place" id="buttonDiv">
            <button class="btn btn-success mr-1 mb-1 btn2-edit" type="button">Bulk Approve</button>
            <button class="btn btn-danger mr-1 mb-1 btn3-edit edit" type="button">Bulk Reject</button>
        </div>

    </div>

    <!-- USER GROUPS INFORMATION -->

    <div class="content-container">

        <div class="new-users-headers-container">
            <div class="block-a"> </div>
            <div class="block-b">Registered Date</div>
            <div class="block-c">User Email</div>
            <div class="block-d">Name</div>
            <div class="block-e">Action</div>
        </div>

        <div class="new-user-container">
            <div class="new-user-info">
                <div class="block-a">
                    <p>
                    <div class="input-group custom-control">
                        <div class="checkbox checkbox-edit">
                            <input class="checkbox checkbox-edit" type="checkbox" id="check" onclick="DivShowHide(this)" />
                        </div>
                    </div>
                    </p>
                </div>
                <div class="block-b">
                    <div class="block-title">
                        <p>Registered Date</p>
                        <p>:</p>
                    </div>
                    <p>17/09/21</p>
                </div>
                <div class="block-c">
                    <div class="block-title">
                        <p>User Email</p>
                        <p>:</p>
                    </div>
                    <p>someone@gmail.com</p>
                </div>
                <div class="block-d">
                    <div class="block-title">
                        <p>Name</p>
                        <p>:</p>
                    </div>
                    <p>Phu M. Phang</p>
                </div>
                <div class="block-e">
                    <p>
                        <button class="btn btn-info mr-1 mb-1 btn1-edit" type="button">View</button>
                        <button class="btn btn-success mr-1 mb-1 btn2-edit" type="button">Approve</button>
                        <button class="btn btn-danger mr-1 mb-1 btn3-edit" type="button">Reject</button>
                    </p>
                </div>
            </div>
            <div class="new-user-info">
                <div class="block-a">
                    <p>
                    <div class="input-group custom-control">
                        <div class="checkbox checkbox-edit">
                            <input class="checkbox checkbox-edit" type="checkbox" id="check" onclick="DivShowHide(this)" />
                        </div>
                    </div>
                    </p>
                </div>
                <div class="block-b">
                    <div class="block-title">
                        <p>Registered Date</p>
                        <p>:</p>
                    </div>
                    <p>17/09/21</p>
                </div>
                <div class="block-c">
                    <div class="block-title">
                        <p>User Email</p>
                        <p>:</p>
                    </div>
                    <p>someone@gmail.com</p>
                </div>
                <div class="block-d">
                    <div class="block-title">
                        <p>Name</p>
                        <p>:</p>
                    </div>
                    <p>Phu M. Phang</p>
                </div>
                <div class="block-e">
                    <p>
                        <button class="btn btn-info mr-1 mb-1 btn1-edit" type="button">View</button>
                        <button class="btn btn-success mr-1 mb-1 btn2-edit" type="button">Approve</button>
                        <button class="btn btn-danger mr-1 mb-1 btn3-edit" type="button">Reject</button>
                    </p>
                </div>
            </div>
            <div class="new-user-info">
                <div class="block-a">
                    <p>
                    <div class="input-group custom-control">
                        <div class="checkbox checkbox-edit">
                            <input class="checkbox checkbox-edit" type="checkbox" id="check" onclick="DivShowHide(this)" />
                        </div>
                    </div>
                    </p>
                </div>
                <div class="block-b">
                    <div class="block-title">
                        <p>Registered Date</p>
                        <p>:</p>
                    </div>
                    <p>17/09/21</p>
                </div>
                <div class="block-c">
                    <div class="block-title">
                        <p>User Email</p>
                        <p>:</p>
                    </div>
                    <p>someone@gmail.com</p>
                </div>
                <div class="block-d">
                    <div class="block-title">
                        <p>Name</p>
                        <p>:</p>
                    </div>
                    <p>Phu M. Phang</p>
                </div>
                <div class="block-e">
                    <p>
                        <button class="btn btn-info mr-1 mb-1 btn1-edit" type="button">View</button>
                        <button class="btn btn-success mr-1 mb-1 btn2-edit" type="button">Approve</button>
                        <button class="btn btn-danger mr-1 mb-1 btn3-edit" type="button">Reject</button>
                    </p>
                </div>
            </div>
            <div class="new-user-info">
                <div class="block-a">
                    <p>
                    <div class="input-group custom-control">
                        <div class="checkbox checkbox-edit">
                            <input class="checkbox checkbox-edit" type="checkbox" id="check" onclick="DivShowHide(this)" />
                        </div>
                    </div>
                    </p>
                </div>
                <div class="block-b">
                    <div class="block-title">
                        <p>Registered Date</p>
                        <p>:</p>
                    </div>
                    <p>17/09/21</p>
                </div>
                <div class="block-c">
                    <div class="block-title">
                        <p>User Email</p>
                        <p>:</p>
                    </div>
                    <p>someone@gmail.com</p>
                </div>
                <div class="block-d">
                    <div class="block-title">
                        <p>Name</p>
                        <p>:</p>
                    </div>
                    <p>Phu M. Phang</p>
                </div>
                <div class="block-e">
                    <p>
                        <button class="btn btn-info mr-1 mb-1 btn1-edit" type="button">View</button>
                        <button class="btn btn-success mr-1 mb-1 btn2-edit" type="button">Approve</button>
                        <button class="btn btn-danger mr-1 mb-1 btn3-edit" type="button">Reject</button>
                    </p>
                </div>
            </div>
            <div class="new-user-info">
                <div class="block-a">
                    <p>
                    <div class="input-group custom-control">
                        <div class="checkbox checkbox-edit">
                            <input class="checkbox checkbox-edit" type="checkbox" id="check" onclick="DivShowHide(this)" />
                        </div>
                    </div>
                    </p>
                </div>
                <div class="block-b">
                    <div class="block-title">
                        <p>Registered Date</p>
                        <p>:</p>
                    </div>
                    <p>17/09/21</p>
                </div>
                <div class="block-c">
                    <div class="block-title">
                        <p>User Email</p>
                        <p>:</p>
                    </div>
                    <p>someone@gmail.com</p>
                </div>
                <div class="block-d">
                    <div class="block-title">
                        <p>Name</p>
                        <p>:</p>
                    </div>
                    <p>Phu M. Phang</p>
                </div>
                <div class="block-e">
                    <p>
                        <button class="btn btn-info mr-1 mb-1 btn1-edit" type="button">View</button>
                        <button class="btn btn-success mr-1 mb-1 btn2-edit" type="button">Approve</button>
                        <button class="btn btn-danger mr-1 mb-1 btn3-edit" type="button">Reject</button>
                    </p>
                </div>
            </div>
            <div class="new-user-info">
                <div class="block-a">
                    <p>
                    <div class="input-group custom-control">
                        <div class="checkbox checkbox-edit">
                            <input class="checkbox checkbox-edit" type="checkbox" id="check" onclick="DivShowHide(this)" />
                        </div>
                    </div>
                    </p>
                </div>
                <div class="block-b">
                    <div class="block-title">
                        <p>Registered Date</p>
                        <p>:</p>
                    </div>
                    <p>17/09/21</p>
                </div>
                <div class="block-c">
                    <div class="block-title">
                        <p>User Email</p>
                        <p>:</p>
                    </div>
                    <p>someone@gmail.com</p>
                </div>
                <div class="block-d">
                    <div class="block-title">
                        <p>Name</p>
                        <p>:</p>
                    </div>
                    <p>Phu M. Phang</p>
                </div>
                <div class="block-e">
                    <p>
                        <button class="btn btn-info mr-1 mb-1 btn1-edit" type="button">View</button>
                        <button class="btn btn-success mr-1 mb-1 btn2-edit" type="button">Approve</button>
                        <button class="btn btn-danger mr-1 mb-1 btn3-edit" type="button">Reject</button>
                    </p>
                </div>
            </div>
        </div>

    </div>

    <!-- FOOTER -->

    <div class="footer-edit">
        <?php
        include_once dirname(dirname(__DIR__)) . './components/footer.php';
        ?>
    </div>

    <!-- SCRITPT -->

    <script src="/javascript/nav.js"></script>
    <script src="/javascript/verify-new-users.js"></script>

</body>

</html>