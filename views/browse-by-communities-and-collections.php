<?php

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
    <link rel="stylesheet" href="/css/global-styles/paginate.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />


    <!-- Aces css framework -->
    <link rel="stylesheet" href="/css/aces-css-framework/style.css">

    <!-- Local Styles -->
    <!-- <link rel="stylesheet" href="/css/local-styles/search.css"> -->
    <link rel="stylesheet" href="/css/local-styles/browse-communities-and-collections.css">


    <title>Browse Content</title>
</head>

<body>
    <!-- NAVIGATION BAR -->
    <?php include_once __DIR__ . '/components/nav.php'; ?>

    <!-- SEARCH CONTENT -->
    <div class="heading-container">
        <!-- Browse -->
    </div>
    <div class="main-container">
        <div class="wrapper">
            <!-- <div class='browse-breadcrumb-container'> -->
            <?php include_once dirname(__DIR__) . '/views/components/breadcrum-v2.php'; ?>
            <!-- </div> -->
            <div class="main-page-devider">
                <div class='main-data-container'>

                    <h1><?= $params['selected-item']->name ?></h1>

                    <?php if ($params['type'] == 'collection') { ?>
                        <p class='type-text'>Collection</p>
                    <?php } else if ($params['type'] == 'community') { ?>
                        <p class='type-text'>Community</p>
                    <?php } ?>

                    <p class='description-text'><?= $params['selected-item']->description ?></p>

                    <p class='browse-by-text'>Browse <span style="font-style: italic;"><?= $params['selected-item']->name ?></span> by </p>
                    <div class="filters-container">
                        <?php if ($params['type'] == 'community') { ?>
                            <a class='browse-filter' href="/browse?community=<?= $params['selected-item']->community_id ?>&type=dateissued">Date issued</a>
                            <a class='browse-filter' href="/browse?community=<?= $params['selected-item']->community_id ?>&type=title">Title</a>
                        <?php } else if ($params['type'] == 'collection') { ?>
                            <a class='browse-filter' href="/browse?collection=<?= $params['selected-item']->collection_id ?>&type=dateissued">Date issued</a>
                            <a class='browse-filter' href="/browse?collection=<?= $params['selected-item']->collection_id ?>&type=title">Title</a>
                        <?php } ?>
                    </div>


                    <?php if ($params['type'] == 'community') { ?>
                        <!-- sub communities list -->
                        <?php if ($params['communities_of_dir']) { ?>
                            <div class="communities-container">
                                <p class='sub-community-title'>Sub communities</p>
                                <div class='sub-communities-inner-container'>
                                    <?php foreach ($params['communities_of_dir'] as $community) { ?>
                                        <div class="collection-data-row">
                                            <a href="/browse/community?community_id=<?= $community->community_id ?>"><?= $community->name ?></a>
                                            <?php if (Application::$app->getUserRole() <= 2) { ?>
                                                <form action="/admin/delete-community" method="POST" onclick="return confirm('Are you sure?')">
                                                    <input type="hidden" name="redirect-parent" value="<?= $params['redirect-parent']  ?>" />
                                                    <button class="delete-btn" name="community-id" value="<?= $community->community_id ?>"><i class="fas fa-trash"></i></button>
                                                </form>
                                            <?php } ?>
                                        </div>

                                    <?php } ?>
                                </div>
                            </div>
                        <?php } ?>

                        <!-- Collections list -->
                        <?php if ($params['collections_of_dir']) { ?>
                            <div class="collections-container">
                                <p class='collection-title'>Collections</p>
                                <div class="collections-inner-container">
                                    <?php foreach ($params['collections_of_dir'] as $collection) { ?>
                                        <div class="collection-data-row">
                                            <a href="/browse/collection?collection_id=<?= $collection['collection_id'] ?>"><?= $collection['name'] ?></a>
                                            <?php if (Application::$app->getUserRole() <= 2) { ?>
                                                <form action="/admin/delete-collection" method="POST" onclick="return confirm('Are you sure?')">
                                                    <input type="hidden" name="redirect-parent" value="<?= $collection['community_id']  ?>" />
                                                    <button class="delete-btn" name="collection-id" value="<?= $collection['collection_id'] ?>"><i class="fas fa-trash"></i></button>
                                                </form>
                                            <?php } ?>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        <?php } ?>
                    <?php } ?>
                </div>


                <?php if (Application::$app->user && Application::getUserRole() <= 2) { ?>
                    <div class='admin-tools-container'>
                        <div class=" admin-tools-container-header">
                            <span>
                                <i class="fas fa-tools"></i>
                                <p>Admin tools</p>
                            </span>
                        </div>
                        <div class="admin-tools-buttons-container">
                            <?php if ($params['type'] == 'community') { ?>
                                <button id="edit-community" class='admin-option-btn' data-id="<?= $params['selected-item']->community_id ?>">Edit this Community</button>
                                <button id="create-sub-community" class='admin-option-btn' data-id="<?= $params['selected-item']->community_id ?>">Create Sub Community</button>
                                <button id="create-collection" class='admin-option-btn' data-id="<?= $params['selected-item']->community_id ?>">Create Collection</button>
                            <?php } ?>

                            <?php if ($params['type'] == 'collection') { ?>
                                <button id="edit-collection" class='admin-option-btn' data-id="<?= $params['selected-item']->collection_id ?>">Edit this Collection</button>
                                <button id="upload-content" class='admin-option-btn' data-id="<?= $params['selected-item']->collection_id ?>">Upload Content</button>
                                <button id="export-collection" class='admin-option-btn' data-id="<?= $params['selected-item']->collection_id ?>">Export Collection</button>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>

    <!-- FOOTER -->

    <?php include_once __DIR__ . '/components/footer.php'; ?>

    <!-- SCRITPT -->

    <script src="./javascript/nav.js"></script>
    <script src="./javascript/alert.js"></script>

    <script>
        (() => {
            const editCommunityBtn = document.getElementById('edit-community');
            const createSubCommunityBtn = document.getElementById('create-sub-community');
            const createCollectionBtn = document.getElementById('create-collection');
            const editCollectionBtn = document.getElementById('edit-collection');
            const uploadContentBtn = document.getElementById('upload-content');
            const exportCollection = document.getElementById('export-collection');

            if (editCommunityBtn) {
                editCommunityBtn.addEventListener('click', (e) => {
                    console.log();
                    window.location = `/admin/edit-community?community-id=${e.target.dataset.id}&redirect=browse`;
                })
            }

            if (createSubCommunityBtn) {
                createSubCommunityBtn.addEventListener('click', (e) => {
                    window.location = `/admin/create-sub-community?parent-id=${e.target.dataset.id}&redirect=browse`;
                })
            }

            if (createCollectionBtn) {
                createCollectionBtn.addEventListener('click', (e) => {
                    window.location = `/admin/create-collection?community-id=${e.target.dataset.id}&redirect=browse`;
                })
            }


            if (editCollectionBtn) {
                editCollectionBtn.addEventListener('click', (e) => {
                    window.location = `/admin/edit-collection?collection-id=${e.target.dataset.id}&redirect=browse`;
                })
            }

            if (uploadContentBtn) {
                uploadContentBtn.addEventListener('click', (e) => {
                    window.location = `/admin/edit-collection?collection-id=${e.target.dataset.id}&redirect=browse`;
                })
            }

            if (exportCollection) {
                exportCollection.addEventListener('click', (e) => {
                    window.location = `/admin/edit-collection?collection-id=${e.target.dataset.id}&redirect=browse`;
                })
            }
        })();
    </script>
</body>

</html>