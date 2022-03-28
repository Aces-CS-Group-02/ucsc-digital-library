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
    <link rel="stylesheet" href="./css/global-styles/style.css">
    <link rel="stylesheet" href="./css/global-styles/nav.css">
    <link rel="stylesheet" href="./css/global-styles/footer.css">


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Aces css framework -->
    <link rel="stylesheet" href="./css/aces-css-framework/style.css">

    <!-- Local Styles -->
    <link rel="stylesheet" href="./css/local-styles/content-abstract-info.css">


    <title>Document</title>
</head>

<body>

    <?php include_once __DIR__ . '/components/nav.php'; ?>

    <?php $contentObj = $params['content'] ?>

    <div class="wrapper">
        <div class="content-path-display">
            <p class="content-path"><?= $params['content']->path ?></p>
        </div>

        <div class="access-info-container">
            <?php if ($params['content']->permission->permission) { ?>
                <div class="access-forbidden-container">
                    <?php if ($params['content']->permission->grant_type === 'READ' || $params['content']->permission->grant_type === 'READ_DOWNLOAD') { ?>
                        <a href="/content/view?content_id=<?= $params['content']->contentInfo->content_id ?>" class='read-btn'><i class="fas fa-book-reader"></i>Read</a>
                    <?php } ?>
                    <?php if ($params['content']->permission->grant_type === 'READ_DOWNLOAD') { ?>
                        <a href="/content/view?content_id=<?= $params['content']->contentInfo->content_id ?>" class='download-btn' download="<?= $contentObj->contentInfo->title ?>.pdf"><i class="fas fa-download"></i>Download</a>
                    <?php } ?>
                </div>
            <?php } else { ?>
                <div class="access-forbidden-container">
                    <i class="fas fa-lock"></i>
                    <p>You can't access this content</p>
                    <!-- <form action="/get-access-to-content" method="GET"> -->
                    <input id="content-id-selector" type="hidden" name='content-id' value="<?= $params['content']->id ?>" />
                    <button id="get-access-btn" class="get-access-btn">Get Access</button>
                    <!-- </form> -->
                </div>
            <?php } ?>
        </div>



        <!-- Content Items -->

        <div class="info-items-container">


            <!-- Title -->
            <div class="info-item-container first-node">
                <div class="info-item-title">
                    <p>Title:</p>
                </div>
                <div class="info-item-content">
                    <p><?= $contentObj->contentInfo->title ?></p>
                </div>
            </div>



            <!-- Authors -->
            <div class="info-item-container">
                <div class="info-item-title">
                    <p>Authors:</p>
                </div>
                <div class="info-item-content">
                    <?php
                    $authors_arr = [];
                    foreach ($contentObj->authors as $author) {
                        array_push($authors_arr, $author->creator);
                    }
                    $authors_arr = implode(' , ', $authors_arr);
                    ?>
                    <p><?= $authors_arr ?></p>
                </div>
            </div>

            <!-- Issue Date -->
            <div class="info-item-container">
                <div class="info-item-title">
                    <p>Issue Date:</p>
                </div>
                <div class="info-item-content">
                    <p><?= $contentObj->contentInfo->date ?></p>
                </div>
            </div>


            <!-- Abstract -->
            <div class="info-item-container">
                <div class="info-item-title">
                    <p>Abstract:</p>
                </div>
                <div class="info-item-content">
                    <p><?= $contentObj->contentInfo->abstract ?></p>
                </div>
            </div>

            <!-- language -->
            <div class="info-item-container">
                <div class="info-item-title">
                    <p>Language:</p>
                </div>
                <div class="info-item-content">
                    <p><?= $contentObj->language ?></p>
                </div>
            </div>

            <!-- Keywords -->
            <div class="info-item-container">
                <div class="info-item-title">
                    <p>Keywords:</p>
                </div>
                <div class="info-item-content">
                    <?php foreach ($contentObj->keywords as $keyword) { ?>
                        <a href="/search-result?community=-1&sort_by=relavance&order=desc&search_query=<?= $keyword['keyword'] ?>" class="keyword-badge" target="_blank"><?= $keyword['keyword'] ?></a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

    <div class="popup-overlay"></div>

    <div id="pop-up-model" class="model-pop-up">
        <div class="model-header">
            <p class="model-header-title">Lend Books</p>
            <span class="model-close-btn">&times;</span>
        </div>

        <div class="model-content">
            <p id="model-msg"></p>
            <p id="content-title-field"></p>
            <input id="content-id-field" type="hidden" name="content-id" value="" />
            <div class="input-group-c">
                <label>Select lend period</label>
                <select id="lend-duration" name="lend-duration" class="custom-select">
                    <option value="1">1 Week</option>
                    <option value="2">2 Week</option>
                    <option value="3">3 Week</option>
                    <option value="4">4 Week</option>
                </select>
            </div>
        </div>
        <div class="model-bottom-line">
            <button id="request-access-btn" class="btn btn-info">Request to Get Access</button>
        </div>
    </div>

    <!-- FOOTER -->

    <!-- <div class="footer section">
        <div class="wrapper">
            <div class="footer-content">
                <p>© 2021, All rights reserved by University of Colombo School of Computing <br />No: 35, Reid Avenue, Colombo 7, Sri Lanka.</p>
            </div>
        </div>
    </div> -->

    <script src="./javascript/nav.js"></script>
    <!-- <script src="./javascript/pdf-viewer.js"></script> -->
    <script>
        const popupModel = document.getElementById("pop-up-model");
        const popupOverlay = document.querySelector(".popup-overlay");
        const popupCloseBtn = document.querySelector('.model-close-btn');
        const requestAccessBtn = document.querySelector('#request-access-btn');
        const modelMsgBox = document.querySelector("#model-msg");

        const getAccessBtn = document.getElementById('get-access-btn');
        const contentId = document.getElementById('content-id-selector').value;
        getAccessBtn.addEventListener('click', () => {
            const req = new XMLHttpRequest();
            req.open('POST', '/ajax/get-access-to-content');
            req.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
            req.onreadystatechange = function() {
                if (this.readyState === 4 && this.status === 200) {
                    responseData = JSON.parse(this.responseText);
                    // console.log(responseData);
                    if (responseData) {
                        if (responseData.status) {
                            document.getElementById('content-id-field').value = responseData.content_id;
                            document.getElementById('content-title-field').innerText = responseData.title;
                            popupOverlay.classList.add('active');
                            popupModel.classList.add('active');
                        }
                    } else {
                        window.location = "/login";
                    }
                }
            };
            req.send(JSON.stringify({
                "content-id": contentId
            }))
        })

        popupCloseBtn.addEventListener('click', () => {
            popupOverlay.classList.remove('active');
            popupModel.classList.remove('active');
        })

        popupOverlay.addEventListener('click', () => {
            popupOverlay.classList.remove('active');
            popupModel.classList.remove('active');

        })

        requestAccessBtn.addEventListener('click', () => {
            let contentId = document.querySelector('#content-id-field').value;
            let lendDuration = document.querySelector('#lend-duration').value;
            const req = new XMLHttpRequest();
            req.open('POST', '/ajax/get-access-to-content/make-request');
            req.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
            req.onreadystatechange = function() {
                if (this.readyState === 4 && this.status === 200) {
                    responseData = JSON.parse(this.responseText);
                    if (responseData.status) {
                        if (modelMsgBox.classList.contains('err-msg')) {
                            modelMsgBox.classList.remove('err-msg');
                        }
                        modelMsgBox.classList.add('success-msg');
                    } else {
                        if (modelMsgBox.classList.contains('success-msg')) {
                            modelMsgBox.classList.remove('success-msg');
                        }
                        modelMsgBox.classList.add('err-msg');
                    }
                    modelMsgBox.innerText = responseData.msg;
                }
            };
            req.send(JSON.stringify({
                "content-id": contentId,
                "lend-duration": lendDuration
            }))
        })
    </script>
</body>

</html>