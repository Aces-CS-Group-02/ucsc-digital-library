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
    <link rel="stylesheet" href="/css/local-styles/bulk-upload.css">



    <title>Bulk Upload</title>
</head>

<body>

    <!-- NAVIGATION BAR -->

    <?php
    include_once dirname(dirname(__DIR__)) . '/components/nav.php';
    ?>

    <!-- Main Content Container -->

    <div id="bulk-upload-main-content">

        <div class="page-header-container">
            <p id="page-header-title">Bulk Upload</p>
            <?php include_once dirname(dirname(__DIR__)) . '/components/breadcrum.php'; ?>
        </div>
        <div class="wrapper">

            <div class="upper-container">

                <div class="upload-place">
                    <div class="input-group adjustments">
                        <label class="labelPlace" for="file">Upload the contents</label>
                        <form action="">
                            <div class="custom-file" id="file">
                                <input class="custom-file-input" id="customFile" type="file" />
                                <label class="custom-file-label" for="customFile"> </label>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="button-place">
                    <form action="">
                        <button class="btn btn-primary mr-1 mb-1 btn-edit" type="button">Upload</button>
                    </form>
                </div>

            </div>

            <!-- BULK UPLOAD INFORMATION -->

            <div class="content-container">

                <div class="bulk-upload-headers-container">
                    <div class="block-a">Title</div>
                    <div class="block-b">Change Title</div>
                    <div class="block-c"> </div>
                </div>

                <div class="bulk-upload-container">
                    <div class="bulk-upload-info">
                        <div class="block-a">
                            <div class="block-title">
                                <p>Title</p>
                                <p>:</p>
                            </div>
                            <p>Mico architecture.pdf</p>
                        </div>
                        <div class="block-b">
                            <div class="block-title special">
                                <p>Change Title</p>
                                <p>:</p>
                            </div>
                            <div class="input-edit">
                                <form action="">
                                    <div class="input-group input-group-edit">
                                        <input class="form-control form-control-edit" id="Title" type="text" />
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="block-c">
                            <p>
                                <button class="btn btn-success mr-1 mb-1" type="button">Add Metadata</button>
                                <button class="btn btn-danger mr-1 mb-1 btn2-edit" type="button">Discard</button>
                            </p>
                        </div>
                    </div>
                    <div class="bulk-upload-info">
                        <div class="block-a">
                            <div class="block-title">
                                <p>Title</p>
                                <p>:</p>
                            </div>
                            <p>Concepts-of-programming-languages.pdf</p>
                        </div>
                        <div class="block-b">
                            <div class="block-title special">
                                <p>Change Title</p>
                                <p>:</p>
                            </div>
                            <div class="input-edit">
                                <form action="">
                                    <div class="input-group input-group-edit">
                                        <input class="form-control form-control-edit" id="Title" type="text" />
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="block-c">
                            <p>
                                <button class="btn btn-success mr-1 mb-1" type="button">Add Metadata</button>
                                <button class="btn btn-danger mr-1 mb-1 btn2-edit" type="button">Discard</button>
                            </p>
                        </div>
                    </div>
                    <div class="bulk-upload-info">
                        <div class="block-a">
                            <div class="block-title">
                                <p>Title</p>
                                <p>:</p>
                            </div>
                            <p>Linear_Algebra.pdf</p>
                        </div>
                        <div class="block-b">
                            <div class="block-title special">
                                <p>Change Title</p>
                                <p>:</p>
                            </div>
                            <div class="input-edit">
                                <form action="">
                                    <div class="input-group input-group-edit">
                                        <input class="form-control form-control-edit" id="Title" type="text" />
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="block-c">
                            <p>
                                <button class="btn btn-success mr-1 mb-1" type="button">Add Metadata</button>
                                <button class="btn btn-danger mr-1 mb-1 btn2-edit" type="button">Discard</button>
                            </p>
                        </div>
                    </div>
                    <div class="bulk-upload-info">
                        <div class="block-a">
                            <div class="block-title">
                                <p>Title</p>
                                <p>:</p>
                            </div>
                            <p>Java ii.pdf</p>
                        </div>
                        <div class="block-b">
                            <div class="block-title special">
                                <p>Change Title</p>
                                <p>:</p>
                            </div>
                            <div class="input-edit">
                                <form action="">
                                    <div class="input-group input-group-edit">
                                        <input class="form-control form-control-edit" id="Title" type="text" />
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="block-c">
                            <p>
                                <button class="btn btn-success mr-1 mb-1" type="button">Add Metadata</button>
                                <button class="btn btn-danger mr-1 mb-1 btn2-edit" type="button">Discard</button>
                            </p>
                        </div>
                    </div>
                    <div class="bulk-upload-info">
                        <div class="block-a">
                            <div class="block-title">
                                <p>Title</p>
                                <p>:</p>
                            </div>
                            <p>Graph Theory Approach to Transportation Systems Design and Optimization.pdf</p>
                        </div>
                        <div class="block-b">
                            <div class="block-title special">
                                <p>Change Title</p>
                                <p>:</p>
                            </div>
                            <div class="input-edit">
                                <form action="">
                                    <div class="input-group input-group-edit">
                                        <input class="form-control form-control-edit" id="Title" type="text" />
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="block-c">
                            <p>
                                <button class="btn btn-success mr-1 mb-1" type="button">Add Metadata</button>
                                <button class="btn btn-danger mr-1 mb-1 btn2-edit" type="button">Discard</button>
                            </p>
                        </div>
                    </div>
                    <div class="bulk-upload-info">
                        <div class="block-a">
                            <div class="block-title">
                                <p>Title</p>
                                <p>:</p>
                            </div>
                            <p>Learn-javascript-visually.pdf</p>
                        </div>
                        <div class="block-b">
                            <div class="block-title special">
                                <p>Change Title</p>
                                <p>:</p>
                            </div>
                            <div class="input-edit">
                                <form action="">
                                    <div class="input-group input-group-edit">
                                        <input class="form-control form-control-edit" id="Title" type="text" />
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="block-c">
                            <p>
                                <button class="btn btn-success mr-1 mb-1" type="button">Add Metadata</button>
                                <button class="btn btn-danger mr-1 mb-1 btn2-edit" type="button">Discard</button>
                            </p>
                        </div>
                    </div>
                    <div class="bulk-upload-info">
                        <div class="block-a">
                            <div class="block-title">
                                <p>Title</p>
                                <p>:</p>
                            </div>
                            <p>Professional_ JavaScript for Web Developers.pdf</p>
                        </div>
                        <div class="block-b">
                            <div class="block-title special">
                                <p>Change Title</p>
                                <p>:</p>
                            </div>
                            <div class="input-edit">
                                <form action="">
                                    <div class="input-group input-group-edit">
                                        <input class="form-control form-control-edit" id="Title" type="text" />
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="block-c">
                            <p>
                                <button class="btn btn-success mr-1 mb-1" type="button">Add Metadata</button>
                                <button class="btn btn-danger mr-1 mb-1 btn2-edit" type="button">Discard</button>
                            </p>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>


    <!-- FOOTER -->

    <?php
    include_once dirname(dirname(__DIR__)) . '/components/footer.php';
    ?>
    <script src="./javascript/nav.js"></script>

</body>

</html>