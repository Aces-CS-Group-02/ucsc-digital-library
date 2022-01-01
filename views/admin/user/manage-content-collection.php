<?php

use app\core\Application;

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
    <link rel="stylesheet" href="/css/global-styles/paginate.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Aces css framework -->
    <link rel="stylesheet" href="/css/aces-css-framework/style.css">

    <!-- Local Styles -->
    <link rel="stylesheet" href="/css/local-styles/add-users.css">



    <title>Document</title>
</head>

<body>

    <!-- NAVIGATION BAR -->

    <?php
    include_once dirname(dirname(__DIR__)) . '/components/nav.php';
    ?>

    <!-- Main Content Container -->

    <div id="add-users-main-content">

        <div class="page-header-container">
            <p id="page-header-title"><?php echo $params['group']->name ?? "" ?></p>
            <?php include_once dirname(dirname(__DIR__)) . '/components/breadcrum.php'; ?>

        </div>

        <div class="wrapper">

            <!-- Flash Message Succss -->
            <?php

            if (Application::$app->session->getFlashMessage('success')) { ?>
                <div class="alert alert-success" id="flash-msg-alert">
                    <strong>Success!</strong>
                    <?php echo Application::$app->session->getFlashMessage('success'); ?>
                    <button class="close" type="button" id="flash-msg-remove">
                        <span class="font-weight-light"></span>
                        <i class="fas fa-times icon-sucess" style="font-size: 0.73em"></i>
                    </button>
                </div>
            <?php } ?>




            <!-- Flash Message Error -->
            <?php
            if (Application::$app->session->getFlashMessage('error')) { ?>
                <div class="alert alert-warning" id="flash-msg-alert">
                    <strong>Error!</strong>
                    <?php echo Application::$app->session->getFlashMessage('error'); ?>
                    <button class="close" type="button" id="flash-msg-remove">
                        <span class="font-weight-light"></span>
                        <i class="fas fa-times icon-warning" style="font-size: 0.73em"></i>
                    </button>
                </div>
            <?php } ?>

            <div class="tab-btn-container">
                <a class="tab-link-btn active" href="/admin/manage-content-collection?content-collection-id=<?php echo $params['collection']->id ?>">Manage Contents</a>
                <a class="tab-link-btn blured" href="/admin/add-content?content-collection-id=<?php echo $params['collection']->id ?>">Add Contents</a>

            </div>

            <div class="second-border">

                <!-- <div class="upper-container">
                    <div class="button-place">
                        <form action="/admin/create-user-group/review" method="POST">
                            <button class="btn btn-primary mr-1 mb-1" id="btn-edit" disabled>Proceed</button>
                        </form>
                    </div>
                </div> -->

                <div class="search-N-sort-components-container">
                    <div class="search-component-container">
                        <form action="" method="GET">
                            <div class="ug-search-input-wrapper">
                                <input type="text" hidden name='content-collection-id' value="<?php echo $params['collection']->id ?>">
                                <input type="text" placeholder="Search users" name='q' value="<?php echo $params['search_params'] ?? '' ?>">
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

                <?php if ($params['show_request_approval_btn']) { ?>
                    <div class="create-new-community-btn-container">
                        <form action="/admin/request-content-collection-approval" method='POST' id='request-approval-form'>
                            <input type="hidden" id='request-approval-data-field' name='content-collection-id' value='<?php echo $params['collection']->id ?>'>
                        </form>
                        <button class="btn btn-primary" id="request-approval-btn" data-groupid='<?php echo $params['collection']->id ?>'>Request approval</button>
                    </div>
                <?php } ?>

            </div>

            <div class="a-to-z-sort-main-container">
                <p id="a-to-z-sort-name">First Name: </p>
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
                <p id="a-to-z-sort-name">Last Name: </p>
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

            <div class="bulk-select-place" id="buttonDiv">
                <p id="checked-items-container"></p>
                <p class="space-editor">Selected:</p>
                <form action="/push-user-to-user-group" method="POST">
                    <button class="btn btn-danger mr-1 mb-1 btn2-edit" name='user_reg_no' value="<?php echo $params['collection']->id ?>">Add User</button>
                </form>
            </div>

            <!-- ADD USERS INFORMATION -->

            <div class="content-container">

                <div class="add-users-headers-container">
                    <div class="block-a"> </div>
                    <div class="block-b">Content Title</div>
                    <div class="block-c">Content Author</div>
                    <div class="block-f">Action</div>
                </div>

                <?php foreach ($params['content_list'] as $content) { ?>
                    <div class="add-users-container">
                        <div class="add-users-info">
                            <div class="block-a">
                                <p>
                                <div class="input-group custom-control">
                                    <div class="checkbox checkbox-edit">
                                        <input class="checkbox checkbox-edit" data-id="<?php echo $content->contentInfo->content_id; ?>" type="checkbox" id="check" onclick="DivShowHide(this)" />
                                    </div>
                                </div>
                                </p>
                            </div>
                            <div class="block-b">
                                <div class="block-title">
                                    <p>Content Title</p>
                                    <p>:</p>
                                </div>
                                <p><?php echo $content->contentInfo->title ?></p>
                            </div>
                            <div class="block-c">
                                <div class="block-title">
                                    <p>Author</p>
                                    <p>:</p>
                                </div>
                                <p>
                                    <?php

                                    $tempArr = [];
                                    foreach ($content->authors as $author) {
                                        array_push($tempArr, $author->creator);
                                    }
                                    $athors_str = implode(', ', $tempArr);
                                    echo $athors_str;


                                    ?></p>
                            </div>


                            <div class="block-f">
                                <form action="/content-collection/remove-content" method="POST">
                                    <input type="hidden" name="content-collection-id" value="<?php echo $params['collection']->id ?>">
                                    <input type="hidden" name="content-id" value="<?php echo $content->contentInfo->content_id; ?>">
                                    <button class="btn btn-add btn-danger">Remove</button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php } ?>


                <?php if (empty($params['content_list'])) { ?>
                    <p class="no-records-available">No Records Available :(</p>
                <?php } ?>

                <?php

                if (!empty($params['content_list']) && isset($params['pageCount'])) {
                    include_once dirname(dirname(__DIR__)) . '/components/paginate.php';
                }
                ?>

            </div>

        </div>

    </div>

    <!-- FOOTER -->

    <?php
    include_once dirname(dirname(__DIR__)) . '/components/footer.php';
    ?>
    <script src=" /javascript/nav.js"></script>
    <script src="/javascript/add-users.js"></script>

    <Script>
        (() => {
            const dataObj = new Map();
            const requestApprovalBtn = document.getElementById('request-approval-btn');
            const requstApprovalForm = document.getElementById('request-approval-form');
            const requestApprovalDataField = document.getElementById('request-approval-data-field');

            dataObj.set(requestApprovalBtn, requestApprovalBtn.dataset.groupid);
            dataObj.set(requestApprovalDataField, requestApprovalDataField.name);

            const requestApproval = function() {
                requestApprovalBtn.dataset.groupid = dataObj.get(requestApprovalBtn);
                requestApprovalDataField.name = dataObj.get(requestApprovalDataField);
                requestApprovalDataField.value = dataObj.get(requestApprovalBtn);

                if (confirm('Are youre sure? Once you made the request you will not able to edit this group until it get approved. But you can remove it anytime.')) {
                    requstApprovalForm.submit();
                }

            }
            requestApprovalBtn.addEventListener('click', requestApproval, false);
        })();
    </Script>


</body>

</html>