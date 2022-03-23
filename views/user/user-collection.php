<?php
$isLoggedIn = true;


use app\core\Application;

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
    <link rel="stylesheet" href="/css/local-styles/user-collection.css">



    <title>Manage My Collections</title>
</head>

<body>

    <!-- NAVIGATION BAR -->

    <?php
    include_once dirname(__DIR__) . '/components/nav.php';
    ?>

    <!-- Profile Top -->

    <div class="outside-wrapper">
        <div class="profile-banner">
            <div class="profile-banner-img">
            </div>
        </div>

        <div class="profile-user-info wrapper">
            <div class="user-info-container">
                <div class="user-profile-avatar" style="background-image: url(/assets/profile/profile.jpeg);">

                </div>


                <div class="user-info-and-btns-container">
                    <?php

                    $userName = Application::$app->getUserDisplayName();
                    $userEmail = Application::$app->getUserEmail();
                    $userRole = Application::$app->getUserRoleName();

                    ?>
                    <div class="user-info">
                        <div class="user-name-and-user-role">
                            <p id="user-name-id"><?php echo $userName['firstname'] . ' ' . $userName['lastname'] ?></p>
                            <p id="user-name-and-role-seperator">|</p>
                            <p id="user-role-id"><?php echo $userRole; ?></p>
                        </div>

                        <p><?php echo $userEmail['email'] ?></p>
                    </div>

                    <div class="user-profile-settings-btn-container">

                        <div class="each-btn-container">
                            <a class="user-profile-settings-btn" href="/profile/edit">
                                <i class="fas fa-edit"></i>
                                <p>Edit Profile</p>
                            </a>
                        </div>

                        <div class="each-btn-container">
                            <a class="user-profile-settings-btn" href="/user-activity-log.php">
                                <i class="fas fa-clipboard-list"></i>
                                <p>Activity Log</p>
                            </a>
                        </div>

                        <div class="each-btn-container">
                            <a class="user-profile-settings-btn" href="#">
                                <i class="fas fa-users"></i>
                                <p>User Groups</p>
                            </a>
                        </div>

                    </div>
                </div>


            </div>
        </div>


        <!-- Section A -->

        <div class="profile-section-a wrapper">
            <?php
            $collectionModel = $params['model'];
            // echo '<pre>';
            // var_dump($collectionModel->user_collection_id);
            // echo '</pre>';
            // echo $name;
            ?>
            <div class="section-header">
                <p class="section-header-title"><?php echo $collectionModel->name ?></p>
            </div>
            <div class="button-place">
                <!-- <a href="/profile/create-user-collection">
                <button class="btn btn-primary mr-1 mb-1">Create New Collection</button>
            </a> -->
                <a href="/profile/edit-collection?collection-id=<?= $collectionModel->user_collection_id ?>">
                    <button class="btn btn-success mr-1 mb-1 btn1-edit" type="button">Edit</button>
                </a>
                <button class="btn btn-danger mr-1 mb-1 btn2-edit edit" type="button" id="delete-collection">Delete</button>
            </div>

            <div class="profile-grid">

                <?php
                $collectionContent = $params['content'] ?? "";
                $collectionContentData = $params['content_data'] ?? "";
                // echo $collectionContent;
                // var_dump($collectionContent);
                ?>
                <input id="collection_id" class="collection_id" value="<?= $collectionModel->user_collection_id ?>" type="hidden"></input>
                <?php if (empty($collectionContent)) { ?>
                    <p class="no-records-available">No Records Available :(</p>
                <?php } else { ?>
                    <?php foreach ($collectionContentData as $contentData) { ?>

                        <div class="profile-gird-container profile-section-b">
                            <a href="/content/view?content_id=<?= $contentData->content_id ?>" class="edit-link">
                                <div class="profile-grid-item box-shadow-2">
                                    <div class="content-card">
                                        <?php if ($contentData->type == 1) { ?>
                                            <div class="content-card-img" style="background-color: peachpuff;">
                                                <img src="/assets/content-icons/book.png" class="img-class">
                                            </div>
                                        <?php } elseif ($contentData->type == 2) { ?>
                                            <div class="content-card-img" style="background-color: rgb(222, 203, 151);">
                                                <img src="/assets/content-icons/thesis.png" class="img-class">
                                            </div>
                                        <?php } elseif ($contentData->type == 3) { ?>
                                            <div class="content-card-img" style="background-color: rgb(255, 250, 135);">
                                                <img src="/assets/content-icons/publication.png" class="img-class">
                                            </div>
                                        <?php } elseif ($contentData->type == 4) { ?>
                                            <div class="content-card-img" style="background-color: rgb(170, 189, 227);">
                                                <img src="/assets/content-icons/paper.png" class="img-class">
                                            </div>
                                        <?php } elseif ($contentData->type == 5) { ?>
                                            <div class="content-card-img" style="background-color: rgb(215, 174, 245);">
                                                <img src="/assets/content-icons/magazine.png" class="img-class">
                                            </div>
                                        <?php } elseif ($contentData->type == 6) { ?>
                                            <div class="content-card-img" style="background-color: rgb(177, 224, 200);">
                                                <img src="/assets/content-icons/newsletter.png" class="img-class">
                                            </div>
                                        <?php } elseif ($contentData->type == 7) { ?>
                                            <div class="content-card-img" style="background-color: rgb(190, 204, 196);">
                                                <img src="/assets/content-icons/audio.png" class="img-class">
                                            </div>
                                        <?php } elseif ($contentData->type == 8) { ?>
                                            <div class="content-card-img" style="background-color: rgb(250, 207, 224);">
                                                <img src="/assets/content-icons/video.png" class="img-class">
                                            </div>
                                        <?php } elseif ($contentData->type == 9) { ?>
                                            <div class="content-card-img" style="background-color: rgb(187, 230, 181);">
                                                <img src="/assets/content-icons/other.png" class="img-class">
                                            </div>
                                        <?php } ?>
                            </a>

                            <div class="content-card-bottom">
                                <p class="content-card-bottom-title line-clamp line-clamp-2-description"><?= $contentData->title ?></p>
                                <div class="content-card-icon">
                                    <!-- <input id="content_id" name="content_id" value="<?= $contentData->content_id ?>" type="hidden"></input> -->
                                    <!-- <input id="collection_id" class="collection_id" value="<?= $collectionModel->user_collection_id ?>" type="hidden"></input> -->
                                    <button id="content_id" class="delete-content content_id" value="<?= $contentData->content_id ?>" style="all: unset;"><i class="fas fa-trash" id="delete-content"></i></button>
                                </div>
                            </div>
                        </div>
            </div>
        </div>

<?php }
                } ?>

    </div>
    </div>
    </div>
    <!-- FOOTER -->

    <?php
    include_once dirname(__DIR__) . '/components/footer.php';
    ?>

    <script src="/javascript/nav.js"></script>
    <script src="/javascript/user-collection.js"></script>
</body>

</html>