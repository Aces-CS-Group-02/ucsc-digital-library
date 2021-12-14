<?php
$isLoggedIn = false;
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


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Aces css framework -->
    <link rel="stylesheet" href="/css/aces-css-framework/style.css">

    <!-- Local Styles -->
    <link rel="stylesheet" href="/css/local-styles/pdf-viewer.css">


    <title>A Christmas Carol</title>
</head>

<body>

    <!-- NAVIGATION BAR -->

    <?php include_once __DIR__ . '/components/nav.php'; ?>

    <div class="pdf-viewer-page-main-container">
        <div class="pdf-viewer-side-bar">
            <div id="side-bar-expand-btn" class="side-bar-block-s">
                <i class="fas fa-bars"></i>
                <!-- <i class="fas fa-arrow-alt-circle-right"></i> -->
            </div>
            <div class="side-bar-block-s">
                <i class="fas fa-bookmark"></i>
            </div>
            <div id="add-notes-btn" class="side-bar-block-s add-notes-btn">
                <i class="fas fa-notes-medical"></i>
            </div>
            <div class="side-bar-block-s">
                <i class="fas fa-folder-plus"></i>
            </div>
        </div>
        <div class="pdf-viewer-container" id="scroll-div">
            <!-- CONTENT CONTAINER -->

            <div class="top-bar">
                <span class="page-info">
                    Page <span id="page-num"></span> of <span id="page-count"></span>
                </span>
            </div>

            <div class="canvas-container" id="pdf-render"></div>
        </div>

        <!-- ADD NOTES MODAL  -->

        <div id="notesModal" class="modal">
            <div class="modal-content">
                <form id="notes-modal-form" action="" method="POST">
                    <div class="notes-modal-top-section notes-modal-title">
                        <div class="notes-title-section">Notes</div>
                        <div class="close-note">
                            <span class="edit-close-note">&times;</span>
                        </div>
                    </div>
                    <div class="input-group edit-notes-input-group">
                        <input type="textarea" class="form-control edit-notes-form-control" id="reason" name="reason" placeholder="Enter the reason"></input>
                    </div>
                    <div class="notes-modal-bottom-section">
                        <button class="btn btn-info mr-1 mb-1" name="request_id" id="add-note" type="submit">Okay</button>
                    </div>
                </form>
            </div>
        </div>

    </div>

    <div class="pdf-viewer-overlay"></div>

    <div class="pdf-viewer-side-bar-expanded">
        <div class="side-bar-sections-container">


            <div class="side-bar-section">
                <div class="side-bar-section-top">
                    <i class="fas fa-bookmark"></i>
                    <p>Bookmarks</p>
                    <button id="add-bookmark-btn"><i class="fas fa-plus"></i></button>
                </div>
                <div class="side-bar-section-content">
                    <div class="bookmark-card"></div>
                    <div class="bookmark-card"></div>
                    <div class="bookmark-card"></div>
                    <div class="bookmark-card"></div>
                    <div class="bookmark-card"></div>
                    <div class="bookmark-card"></div>
                    <div class="bookmark-card"></div>
                    <div class="bookmark-card"></div>
                    <div class="bookmark-card"></div>
                    <div class="bookmark-card"></div>
                    <div class="bookmark-card"></div>
                    <div class="bookmark-card"></div>
                    <div class="bookmark-card"></div>
                    <div class="bookmark-card"></div>
                </div>
                <div class="side-bar-section-expand-collaps">
                    <button class="side-bar-section-expand-collaps-btn">
                        <i class="fas fa-chevron-down"></i>

                    </button>
                </div>
            </div>

            <div class="side-bar-section">
                <div class="side-bar-section-top">
                    <i class="fas fa-notes-medical"></i>
                    <p>Add Notes</p>
                    <button id="add-notes-btn" class="add-notes-btn"><i class="fas fa-plus"></i></button>
                </div>
                <div class="side-bar-section-expand-collaps no-content">
                </div>
            </div>




        </div>
    </div>

    <script src="https://mozilla.github.io/pdf.js/build/pdf.js"></script>
    <script src="/javascript/nav.js"></script>
    <script src="/javascript/pdf-viewer.js"></script>
</body>

</html>