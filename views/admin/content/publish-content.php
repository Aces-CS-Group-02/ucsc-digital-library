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
    <link rel="stylesheet" href="/css/local-styles/publish-content.css">



    <title>Document</title>
</head>

<body>

    <!-- NAVIGATION BAR -->

    <?php
    include_once dirname(dirname(__DIR__)) . '/components/nav.php';
    ?>


    <!-- Main Content Container -->

    <div id="publish-content-main-content">
        <div class="page-header-container">
            <p id="page-header-title">Publish Content</p>
        </div>
        <div class="wrapper">
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
                                <option value="1">Title</option>
                                <option value="2">Creator</option>
                                <option value="3">Type</option>
                                <option value="4">Date</option>
                            </select>
                        </div>
                    </form>
                </div>
            </div>

            <div class="a-to-z-sort-main-container">
                <p id="a-to-z-sort-name">Title: </p>
                <div class="a-to-z-sort-component-container">
                    <button class="a-to-z-sort-btn a-to-z-all-btn selected">All</button>
                    <button class="a-to-z-sort-btn">A</button>
                    <button class="a-to-z-sort-btn">B</button>
                    <button class="a-to-z-sort-btn">C</button>
                    <button class="a-to-z-sort-btn">D</button>
                    <button class="a-to-z-sort-btn">E</button>
                    <button class="a-to-z-sort-btn">F</button>
                    <button class="a-to-z-sort-btn">G</button>
                    <button class="a-to-z-sort-btn">H</button>
                    <button class="a-to-z-sort-btn">I</button>
                    <button class="a-to-z-sort-btn">J</button>
                    <button class="a-to-z-sort-btn">K</button>
                    <button class="a-to-z-sort-btn">L</button>
                    <button class="a-to-z-sort-btn">M</button>
                    <button class="a-to-z-sort-btn">N</button>
                    <button class="a-to-z-sort-btn">O</button>
                    <button class="a-to-z-sort-btn">P</button>
                    <button class="a-to-z-sort-btn">Q</button>
                    <button class="a-to-z-sort-btn">R</button>
                    <button class="a-to-z-sort-btn">S</button>
                    <button class="a-to-z-sort-btn">T</button>
                    <button class="a-to-z-sort-btn">U</button>
                    <button class="a-to-z-sort-btn">V</button>
                    <button class="a-to-z-sort-btn">W</button>
                    <button class="a-to-z-sort-btn">X</button>
                    <button class="a-to-z-sort-btn">Y</button>
                    <button class="a-to-z-sort-btn">Z</button>

                </div>
            </div>

            <div class="a-to-z-sort-main-container second">
                <p id="a-to-z-sort-name">Creator: </p>
                <div class="a-to-z-sort-component-container">
                    <button class="a-to-z-sort-btn a-to-z-all-btn selected">All</button>
                    <button class="a-to-z-sort-btn">A</button>
                    <button class="a-to-z-sort-btn">B</button>
                    <button class="a-to-z-sort-btn">C</button>
                    <button class="a-to-z-sort-btn">D</button>
                    <button class="a-to-z-sort-btn">E</button>
                    <button class="a-to-z-sort-btn">F</button>
                    <button class="a-to-z-sort-btn">G</button>
                    <button class="a-to-z-sort-btn">H</button>
                    <button class="a-to-z-sort-btn">I</button>
                    <button class="a-to-z-sort-btn">J</button>
                    <button class="a-to-z-sort-btn">K</button>
                    <button class="a-to-z-sort-btn">L</button>
                    <button class="a-to-z-sort-btn">M</button>
                    <button class="a-to-z-sort-btn">N</button>
                    <button class="a-to-z-sort-btn">O</button>
                    <button class="a-to-z-sort-btn">P</button>
                    <button class="a-to-z-sort-btn">Q</button>
                    <button class="a-to-z-sort-btn">R</button>
                    <button class="a-to-z-sort-btn">S</button>
                    <button class="a-to-z-sort-btn">T</button>
                    <button class="a-to-z-sort-btn">U</button>
                    <button class="a-to-z-sort-btn">V</button>
                    <button class="a-to-z-sort-btn">W</button>
                    <button class="a-to-z-sort-btn">X</button>
                    <button class="a-to-z-sort-btn">Y</button>
                    <button class="a-to-z-sort-btn">Z</button>

                </div>
            </div>


            <!-- PUBLISH CONTENT INFORMATION -->

            <div class="content-container">

                <div class="publish-contents-headers-container">
                    <div class="block-a">Title</div>
                    <div class="block-b">Creator</div>
                    <div class="block-c">Type</div>
                    <div class="block-d">Date</div>
                    <div class="block-e">Action</div>
                </div>

                <div class="publish-content-container">
                    <div class="publish-content-info">
                        <div class="block-a">
                            <div class="block-title">
                                <p>Title</p>
                                <p>:</p>
                            </div>
                            <p>Software Engineering</p>
                        </div>
                        <div class="block-b">
                            <div class="block-title">
                                <p>Creator</p>
                                <p>:</p>
                            </div>
                            <p>Phu Phung</p>
                        </div>
                        <div class="block-c">
                            <div class="block-title">
                                <p>Type</p>
                                <p>:</p>
                            </div>
                            <p>18/19 CS SCS2201 DSA</p>
                        </div>
                        <div class="block-d">
                            <div class="block-title">
                                <p>Date</p>
                                <p>:</p>
                            </div>
                            <p>17/90/21</p>
                        </div>
                        <div class="block-e">
                            <p>
                                <button class="btn btn-danger mr-1 mb-1 btn-edit" type="button">Publish</button>
                            </p>
                        </div>
                    </div>
                    <div class="publish-content-info">
                        <div class="block-a">
                            <div class="block-title">
                                <p>Title</p>
                                <p>:</p>
                            </div>
                            <p>Software Engineering</p>
                        </div>
                        <div class="block-b">
                            <div class="block-title">
                                <p>Creator</p>
                                <p>:</p>
                            </div>
                            <p>Phu Phung</p>
                        </div>
                        <div class="block-c">
                            <div class="block-title">
                                <p>Type</p>
                                <p>:</p>
                            </div>
                            <p>18/19 CS SCS2201 DSA</p>
                        </div>
                        <div class="block-d">
                            <div class="block-title">
                                <p>Date</p>
                                <p>:</p>
                            </div>
                            <p>17/90/21</p>
                        </div>
                        <div class="block-e">
                            <p>
                                <button class="btn btn-danger mr-1 mb-1 btn-edit" type="button">Publish</button>
                            </p>
                        </div>
                    </div>
                    <div class="publish-content-info">
                        <div class="block-a">
                            <div class="block-title">
                                <p>Title</p>
                                <p>:</p>
                            </div>
                            <p>Software Engineering</p>
                        </div>
                        <div class="block-b">
                            <div class="block-title">
                                <p>Creator</p>
                                <p>:</p>
                            </div>
                            <p>Phu Phung</p>
                        </div>
                        <div class="block-c">
                            <div class="block-title">
                                <p>Type</p>
                                <p>:</p>
                            </div>
                            <p>18/19 CS SCS2201 DSA</p>
                        </div>
                        <div class="block-d">
                            <div class="block-title">
                                <p>Date</p>
                                <p>:</p>
                            </div>
                            <p>17/90/21</p>
                        </div>
                        <div class="block-e">
                            <p>
                                <button class="btn btn-danger mr-1 mb-1 btn-edit" type="button">Publish</button>
                            </p>
                        </div>
                    </div>
                    <div class="publish-content-info">
                        <div class="block-a">
                            <div class="block-title">
                                <p>Title</p>
                                <p>:</p>
                            </div>
                            <p>Software Engineering</p>
                        </div>
                        <div class="block-b">
                            <div class="block-title">
                                <p>Creator</p>
                                <p>:</p>
                            </div>
                            <p>Phu Phung</p>
                        </div>
                        <div class="block-c">
                            <div class="block-title">
                                <p>Type</p>
                                <p>:</p>
                            </div>
                            <p>18/19 CS SCS2201 DSA</p>
                        </div>
                        <div class="block-d">
                            <div class="block-title">
                                <p>Date</p>
                                <p>:</p>
                            </div>
                            <p>17/90/21</p>
                        </div>
                        <div class="block-e">
                            <p>
                                <button class="btn btn-danger mr-1 mb-1 btn-edit" type="button">Publish</button>
                            </p>
                        </div>
                    </div>
                    <div class="publish-content-info">
                        <div class="block-a">
                            <div class="block-title">
                                <p>Title</p>
                                <p>:</p>
                            </div>
                            <p>Software Engineering</p>
                        </div>
                        <div class="block-b">
                            <div class="block-title">
                                <p>Creator</p>
                                <p>:</p>
                            </div>
                            <p>Phu Phung</p>
                        </div>
                        <div class="block-c">
                            <div class="block-title">
                                <p>Type</p>
                                <p>:</p>
                            </div>
                            <p>18/19 CS SCS2201 DSA</p>
                        </div>
                        <div class="block-d">
                            <div class="block-title">
                                <p>Date</p>
                                <p>:</p>
                            </div>
                            <p>17/90/21</p>
                        </div>
                        <div class="block-e">
                            <p>
                                <button class="btn btn-danger mr-1 mb-1 btn-edit" type="button">Publish</button>
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
    <script src="/javascript/nav.js"></script>

</body>

</html>