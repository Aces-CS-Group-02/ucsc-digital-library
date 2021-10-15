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
    <link rel="stylesheet" href="/css/local-styles/admin-add-update-metadata.css">

    <title>Document</title>
</head>

<body>

    <?php
    include_once dirname(dirname(__DIR__)) . '/components/nav.php';
    ?>
    <div class="admin-dashboard-main-content">
        <div class="admin-dashboard-text">
            Add/Update Metadata
        </div>

        <div class="content-metadata">
            <div class="content-dashboard-text">
                Content Metadata
            </div>
            <div class="form-container">
                <form id="form-features">
                    <div class="input-group input-group-override">
                        <label class="labelPlace labelPlace-override" for="title">Title</label>
                        <input class="form-control" id="title" type="text" />
                    </div>
                    <div class="input-group input-group-override">
                        <label class="labelPlace labelPlace-override" for="creator">Creator</label>
                        <input class="form-control" id="creator" type="text" />
                    </div>
                    <div class="input-group input-group-override">
                        <label class="labelPlace labelPlace-override" for="subject">Subject</label>
                        <input class="form-control" id="subject" type="text" />
                    </div>
                    <div class="input-group input-group-override">
                        <label class="labelPlace labelPlace-override" for="language">Language</label>
                        <input class="form-control" id="language" type="text" />
                    </div>
                    <div class="input-group input-group-override">
                        <label class="labelPlace labelPlace-override" for="keywords">Keywords</label>
                        <input class="form-control" id="keywords" type="text" />
                    </div>
                    <div class="input-group input-group-override">
                        <label class="labelPlace labelPlace-override" for="date">Date</label>
                        <input class="form-control" id="date" type="date" />
                    </div>
                </form>
            </div>
        </div>
        <div class="content-metadata">
            <div class="content-dashboard-text">
                E-Book Metadata
            </div>
            <div class="form-container e-book-form-container">
                <form id="form-features">
                    <div class="input-group input-group-override">
                        <label class="labelPlace labelPlace-override" for="publisher">Publisher</label>
                        <input class="form-control" id="publisher" type="text" />
                    </div>
                    <div class="input-group input-group-override">
                        <label class="labelPlace labelPlace-override" for="isbn">ISBN </label>
                        <input class="form-control" id="isbn" type="text" />
                    </div>
                    <div class="input-group input-group-override">
                        <label class="labelPlace labelPlace-override" for="Lname">Abstract</label>
                        <textarea class="form-control" id="abstract"></textarea>
                    </div>
                    <div class="input-group">
                        <button class="btn btn-primary mr-1 mb-1 constant-size" type="button">
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>




    </div>


    <!-- FOOTER -->

    <?php
    include_once dirname(dirname(__DIR__)) . './components/footer.php';
    ?>

    <!-- SCRIPT -->

    <script src="/javascript/nav.js"></script>

</body>

</html>