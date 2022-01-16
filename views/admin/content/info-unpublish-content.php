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
    <link rel="stylesheet" href="/css/local-styles/info-approve-content-collection.css">



    <title>Unpublish Content</title>
</head>

<body>

    <!-- NAVIGATION BAR -->

    <?php
    include_once dirname(dirname(__DIR__)) . '/components/nav.php';
    ?>
    <?php
    $content = $params['model'];
    ?>


    <div class="info-dashboard-main-content">
        <div class="admin-dashboard-text">
            <p id="page-header-title">Unpublish Content Details</p>
            <?php include_once dirname(dirname(__DIR__)) . '/components/breadcrum.php'; ?>
        </div>

        <div class="table-responsive table-margin">
            <div class="btn-grid-container">
                <div class="btn-container">
                    <form action="/admin/unpublish-content/unpublish" method="POST">
                        <button class="btn btn-danger mr-1 mb-1 btn-edit" onclick="confirm('Are you sure?')" name="content_id" value="<?php echo $content->content_id; ?>">Unpublish</button>
                    </form>
                </div>
                <div class="info-items-container">
                    <div class="info-item-container first-node">
                        <div class="info-item-title">
                            <p>Content ID:</p>
                        </div>
                        <div class="info-item-content">
                            <p><?php echo $content->content_id ?></p>
                        </div>
                    </div>

                    <div class="info-item-container ">
                        <div class="info-item-title">
                            <p>Title:</p>
                        </div>
                        <div class="info-item-content">
                            <p><?php echo $content->title ?></p>
                        </div>
                    </div>
                    <div class="info-item-container ">
                        <div class="info-item-title">
                            <p>Subject:</p>
                        </div>
                        <div class="info-item-content">
                            <p><?php echo $content->subject ?></p>
                        </div>
                    </div>
                    <div class="info-item-container ">
                        <div class="info-item-title">
                            <p>Language:</p>
                        </div>
                        <div class="info-item-content">
                            <p><?php echo $content->language ?></p>
                        </div>
                    </div>
                    <div class="info-item-container ">
                        <div class="info-item-title">
                            <p>Abstract:</p>
                        </div>
                        <div class="info-item-content">
                            <p class="line-clamp line-clamp-1-description <?php if ($content->abstract == "") {
                                                                                echo "gray-out";
                                                                            } ?>"><?php
                                                                                    if ($content->abstract == "") {
                                                                                        echo "N/A";
                                                                                    } else {
                                                                                        echo $content->abstract;
                                                                                    }  ?></p>

                        </div>
                    </div>
                    <div class="info-item-container ">
                        <div class="info-item-title">
                            <p>Keywords:</p>
                        </div>
                        <div class="info-item-content">
                            <p class="line-clamp line-clamp-1-description <?php if ($content->keywords === []) {
                                                                                echo "gray-out";
                                                                            } ?>"><?php
                                                                                    if ($content->keywords === []) {
                                                                                        echo "N/A";
                                                                                    } else {
                                                                                        echo $content->keywords;
                                                                                    }  ?></p>
                        </div>
                    </div>
                    <div class="info-item-container ">
                        <div class="info-item-title">
                            <p>Type:</p>
                        </div>
                        <div class="info-item-content">
                            <p class="line-clamp line-clamp-1-description <?php if ($content->type_name === "") {
                                                                                echo "gray-out";
                                                                            } ?>"><?php
                                                                                    if ($content->type_name === "") {
                                                                                        echo "N/A";
                                                                                    } else {
                                                                                        echo $content->type_name;
                                                                                    }  ?></p>

                        </div>
                    </div>
                    <div class="info-item-container">
                        <div class="info-item-title">
                            <p>Creator:</p>
                        </div>
                        <div class="info-item-content">
                            <p><?php
                                echo $content->creators[0]['creator'];
                                for ($i = 1; $i < count($content->creators); $i++) {
                                    echo ', ' . $content->creators[$i]['creator'];
                                } ?></p>
                        </div>
                    </div>
                    <div class="info-item-container ">
                        <div class="info-item-title">
                            <p>Content:</p>
                        </div>
                        <div class="info-item-content ">
                            <a href="/content/view/<?php echo $content->content_id; ?>">View Contents</a>
                        </div>
                    </div>
                    <div class="info-item-container ">
                        <div class="info-item-title">
                            <p>Date</p>
                        </div>
                        <div class="info-item-content">
                            <p><?php
                                $date = new DateTime($content->date);
                                echo $date->format('Y-m-d'); ?></p>
                        </div>
                    </div>
                    <div class="info-item-container ">
                        <div class="info-item-title">
                            <p>Publisher:</p>
                        </div>
                        <div class="info-item-content">
                            <p><?php echo $content->publisher ?></p>
                        </div>
                    </div>
                    <?php if ($content->type_name == "E-Book") { ?>
                        <div class="info-item-container last">
                            <div class="info-item-title">
                                <p>ISBN:</p>
                            </div>
                            <div class="info-item-content">
                                <p class="line-clamp line-clamp-1-description <?php if ($content->isbn == "") {
                                                                                    echo "gray-out";
                                                                                } ?>"><?php
                                                                                        if ($content->isbn == "") {
                                                                                            echo "N/A";
                                                                                        } else {
                                                                                            echo $content->isbn;
                                                                                        }  ?></p>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>


    </div>

    <!-- FOOTER -->

    <?php
    include_once dirname(dirname(__DIR__)) . '/components/footer.php';
    ?>
    <script src="/javascript/nav.js"></script>

</body>

</html>