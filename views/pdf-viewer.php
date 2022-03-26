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

    <?php
    $content = $params['content'];
    $contentType = $content->type;
    $contentId = $content->content_id;
    $contentName = $content->title;
    $permission = $params['permission'];
    $userRegNo = $params['user_reg_no'];
    // var_dump($contentType);
    // echo $userRegNo;
    $url = '/data/content/uploads/' . $contentId . '.pdf';
    // echo json_encode($url);
    ?>
    <title><?= $contentName ?></title>
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
            <?php if ($userRegNo) { ?>
                <div class="side-bar-block-s hover-text add-bookmark-btn" data-hover="Add Bookmark">
                    <i class="fas fa-bookmark"></i>
                </div>
                <div id="add-notes-btn" class="side-bar-block-s add-notes-btn hover-text" data-hover="Add Note">
                    <i class="fas fa-notes-medical"></i>
                </div>
                <div id="add-to-collection-btn" class="side-bar-block-s add-to-collection-btn hover-text" data-hover="Add to Collection">
                    <i class="fas fa-folder-plus"></i>
                </div>
            <?php } ?>
            <?php if ($permission == "READ_DOWNLOAD") { ?>
                <a href="<?= $url ?>" class="edit-anchor" download="<?= $contentName ?>.pdf">
                    <div id="download-btn" class="side-bar-block-s download-btn hover-text" data-hover="Download">
                        <i class="fas fa-download"></i>
                    </div>
                </a>
            <?php } ?>
            <?php if ($contentType != 4) { ?>
                <div id="get-citation-btn" class="side-bar-block-s get-citation-btn hover-text" data-hover="Get Citations">
                    <i class="fas fa-quote-right"></i>
                </div>
            <?php } ?>
            <div id="share-btn" class="side-bar-block-s share-btn hover-text" data-hover="Share">
                <i class="fas fa-share"></i>
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
            <div class="modal-content" id="notes-modal-content">
                <form id="notes-modal-form" action="/ajax/get-user-notes" method="POST">
                    <div class="notes-modal-top-section notes-modal-title">
                        <div class="notes-title-section">Notes</div>
                        <div class="close-note">
                            <span class="edit-close-note">&times;</span>
                        </div>
                    </div>
                    <textarea id="note-data" name="note"></textarea>
                    <input name="content_id" value="<?= $contentId ?>" type="hidden"></input>
                    <div class="notes-modal-bottom-section">
                        <button id="delete-note-btn"><i class="bookmark-dlt-icon fas fa-trash" id="delete-content"></i></button>
                        <button class="btn btn-info mr-1 mb-1" id="add-note">Save</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- SHARE MODAL  -->

        <div id="shareModal" class="modal">
            <div class="modal-content" id="share-modal-content">
                <div class="notes-modal-top-section notes-modal-title">
                    <div class="notes-title-section">Use this link to share</div>
                    <div class="close-share">
                        <span class="edit-close-note">&times;</span>
                    </div>
                </div>
                <div class="share-modal-middle-content">
                    <textarea class="share-link-container" readonly></textarea>
                </div>
                <div class="notes-modal-bottom-section citations-modal-bottom">
                    <button class="btn btn-info mr-1 mb-1" id="copy-share-link" onclick="copyShareLink()">Copy</button>
                    <div class="link-copy-msg">Copied!</div>
                </div>
            </div>
        </div>

        <!-- CITATIONS MODAL  -->

        <div id="citationsModal" class="modal">
            <div class="modal-content" id="citations-modal-content">
                <div class="notes-modal-top-section notes-modal-title">
                    <div class="notes-title-section">Citations</div>
                    <div class="close-citation">
                        <span class="edit-close-note">&times;</span>
                    </div>
                </div>
                <div class="citation-type-selector">
                    <form action="/ajax/get-citation" method="POST" id="citation-select-form">
                        <div class="input-group sort-input-edited" id="adjustments">
                            <label class="labelPlace edit-label" for="select">Citation Type: </label>
                            <select class="custom-select custom-select-edited" id="select-citation" name="type">
                                <option value="0">Select Type</option>
                                <option value="1">IEEE</option>
                                <option value="2">ACM</option>
                            </select>
                        </div>
                    </form>
                </div>
                <textarea id="citation-data" readonly></textarea>
                <div class="notes-modal-bottom-section citations-modal-bottom">
                    <button class="btn btn-info mr-1 mb-1" id="copy-citation" onclick="copyCitation()">Copy</button>
                    <div class="copy-msg">Copied!</div>
                </div>
            </div>
        </div>

        <!-- ADD TO COLLECTIONS MODAL  -->

        <div id="collectionsModal" class="modal">
            <div class="modal-content" id="collections-modal-content">
                <div class="notes-modal-top-section notes-modal-title">
                    <div class="notes-title-section">Add to my collection</div>
                    <div class="close-collection">
                        <span class="edit-close-note">&times;</span>
                    </div>
                </div>
                <div class="modal-middle-content" id="collection-modal-collections">
                    <!-- <div class="input-group custom-control">
                            <div class="checkbox checkbox-edit">
                                <input class="checkbox checkbox-edit" type="checkbox" id="check" onclick="DivShowHide(this)" />
                                Favourites
                            </div>
                        </div> -->
                </div>
                <form id="collections-modal-form" action="" method="">

                    <div class="notes-modal-bottom-section edit-for-collection">
                        <div class="new-collection-create">
                            New Collection Name
                        </div>
                        <div class="input-group edit-input-group">
                            <input type="text" class="form-control edit-form-control create-collection" id="name" name="name" placeholder="Enter collection name"></input>
                            <!-- <input id="content_id" name="content_id" value="<?= $contentId ?>" type="hidden"></input> -->
                        </div>
                        <div class="btn-container" id="create-and-save">
                            <div class="btn btn-info mr-1 mb-1" id="add-collection">Create and Add</div>
                        </div>
                        <div class="message-container" id="message-container">
                            <!-- Test -->
                        </div>
                        <!-- <div class="btn-container-hidden" id="save-btn-container">
                            <button class="btn btn-info mr-1 mb-1" name="request_id" id="add-note" type="submit">Add</button>
                        </div> -->
                    </div>

                </form>
            </div>
        </div>

    </div>

    <div class="pdf-viewer-overlay"></div>

    <div class="pdf-viewer-side-bar-expanded">
        <div class="side-bar-sections-container">

            <?php if ($userRegNo) { ?>

                <div class="side-bar-section">
                    <div class="side-bar-section-top">
                        <i class="fas fa-bookmark"></i>
                        <p>Bookmarks</p>
                        <button id="add-bookmark-btn" class="add-bookmark-btn"><i class="fas fa-plus"></i></button>
                    </div>
                    <div class="side-bar-section-content" id="side-bar-section-content">
                        <!-- <div class="bookmark-card"></div>
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
                        <div class="bookmark-card"></div> -->
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
                        <p>Notes</p>
                        <button id="add-notes-btn" class="add-notes-btn"><i class="fas fa-plus"></i></button>
                    </div>
                    <div class="side-bar-section-expand-collaps no-content">
                    </div>
                </div>


                <div class="side-bar-section">
                    <div class="side-bar-section-top">
                        <i class="fas fa-folder-plus"></i>
                        <p>Add To Collection</p>
                        <button id="add-to-collection-btn" class="add-to-collection-btn"><i class="fas fa-plus"></i></button>
                    </div>
                    <div class="side-bar-section-expand-collaps no-content">
                    </div>
                </div>
            <?php } ?>



            <?php if ($permission == "READ_DOWNLOAD") { ?>
                <a href="<?= $url ?>" class="edit-anchor" download="<?= $contentName ?>.pdf">
                    <div class="side-bar-section">
                        <div class="side-bar-section-top">
                            <i class="fas fa-download"></i>
                            <p>Download</p>
                            <button id="download-btn" class="download-btn"></button>
                        </div>
                        <div class="side-bar-section-expand-collaps no-content">
                        </div>
                    </div>
                </a>
            <?php } ?>

            <?php if ($contentType != 4) { ?>
                <div class="side-bar-section get-citation-btn" id="get-citation-btn">
                    <div class="side-bar-section-top">
                        <i class="fas fa-quote-right"></i>
                        <p>Get Citations</p>
                        <!-- <button id="get-citation-btn" class="get-citation-btn"></button> -->
                    </div>
                    <div class="side-bar-section-expand-collaps no-content">
                    </div>
                </div>
            <?php } ?>

            <div class="side-bar-section share-btn">
                <div class="side-bar-section-top">
                    <i class="fas fa-share"></i>
                    <p>Share</p>
                    <!-- <button id="share-btn" class="share-btn"></button> -->
                </div>
                <div class="side-bar-section-expand-collaps no-content">
                </div>
            </div>

        </div>
    </div>

    <script src="https://mozilla.github.io/pdf.js/build/pdf.js"></script>
    <!-- <script src="https://cdn.ckeditor.com/4.17.1/standard-all/ckeditor.js"></script> -->
    <script src="/ckeditor/ckeditor.js"></script>
    <script src="/javascript/nav.js"></script>
    <script type="text/javascript">
        var contentUrl = "<?= $url ?>";
        var contentId = "<?= $contentId ?>";
        var regNo = "<?= $userRegNo ?>";
    </script>
    <script type="text/javascript" src="/javascript/pdf-viewer.js"></script>
    <script>
        CKEDITOR.replace('note', {
            toolbar: [
                // ['Format', '-', 'Bold', 'Italic', '-', 'NumberedList', 'BulletedList', '-', 'Link', '-', 'Undo', 'Redo']
                ['Format', '-', 'Bold', 'Italic', '-', 'NumberedList', 'BulletedList', '-', 'Undo', 'Redo']
            ],
            height: 300,
            wordcount: {
                showParagraphs: false,
                showWordCount: true,
                showCharCount: true,
                countSpacesAsChars: true,
                countHTML: false,
                maxWordCount: -1,
                maxCharCount: 1000
            },
            editorplaceholder: 'Enter your text here',
            htmlEncodeOutput: true
        });
        CKEDITOR.config.removePlugins = 'resize';
    </script>
</body>

</html>