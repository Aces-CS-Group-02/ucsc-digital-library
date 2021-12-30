<?php
$isLoggedIn = false;

use app\core\Application;
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
    <link rel="stylesheet" href="./css/local-styles/help.css">

    <title>UCSC Digital Library Help</title>
</head>

<body>

    <!-- NAVIGATION BAR -->
    <?php include_once __DIR__ . '/components/nav.php' ?>
    <div id="scroll-bar">
        <div class="head-container">
            UCSC Digital Library Help
        </div>


        <div class="btn-container">
            <div class="container">
                <div class="card box-shadow-1">
                    <div class="card-item-text">
                        <p class="card-item-title">Help Contents</p>

                        <div class="btn-set">
                            <a href="#browse" class="btn btn-outline-secondary mr-1 mb-1 txt-dec">
                                Browse
                            </a>

                            <a href="#search" class="btn btn-outline-secondary mr-1 mb-1 txt-dec">
                                Search
                            </a>

                            <a href="#advancedSearch" class="btn btn-outline-secondary mr-1 mb-1 txt-dec">
                                Advanced Search
                            </a>

                            <a href="#communities" class="btn btn-outline-secondary mr-1 mb-1 txt-dec">
                                Communities
                            </a>

                            <a href="#collections" class="btn btn-outline-secondary mr-1 mb-1 txt-dec">
                                Collections
                            </a>
                            <a href="#signOn" class="btn btn-outline-secondary mr-1 mb-1 txt-dec">
                                Sign On
                            </a>
                            <a href="#submit" class="btn btn-outline-secondary mr-1 mb-1 txt-dec">
                                Submit
                            </a>
                            <a href="#fileFormat" class="btn btn-outline-secondary mr-1 mb-1 txt-dec">
                                File Format
                            </a>
                            <a href="#editProfile" class="btn btn-outline-secondary mr-1 mb-1 txt-dec">
                                Edit Profile
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="outer-container">
            <article id="browse">
                <div class="container">
                    <div class="card type-column box-shadow-1">
                        <div class="card-title" style="background-color: rgba(0, 0, 0, 0.03)">
                            <p>Browse</p>
                        </div>
                        <div class="card-content fw-400">
                            Browse allows you to go through a list of items in some specified order:</br>

                            Browse by Community/Collection takes you through the communities in alphabetical order and allows you to see the subcommunities and collections within each community.</br>

                            Browse by Title allows you to move through an alphabetical list of all titles of items in DSpace.</br>

                            Browse by Author allows you to move through an alphabetical list of all authors of items in DSpace.</br>

                            Browse by Subject allows you to move through an alphabetical list of subjects assigned to items in DSpace.</br>

                            Browse by Date allows you to move through a list of all items in DSpace in reverse chronological order.</br>

                            You may sign on to the system if you:</br>

                            wish to subscribe to a collection and receive e-mail updates when new items are added</br>
                            wish to go to the "My DSpace" page that tracks your subscriptions and other interactions with DSpace requiring authorization (if you are a submitter for a collection, for instance.)</br>
                            wish to edit your profile</br>
                            Submit is the DSpace function that enables users to add an item to DSpace. The process of submission includes filling out information about the item on a metadata form and uploading the file(s) comprising the digital item. Each community sets its own submission policy.</br>

                            My DSpace is a personal page that is maintained for each member. This page can contain a list of items that are in the submission process for a particular member, or a task list of items that need attention such as editing, reviewing, or checking. In the future this page will also maintain information about personal services offered by DSpace, such as e-mail notification when new items are added to a collection.

                            Edit Profile allows you to change your password.</br>

                            About takes you to information about the DSpace project and its development.</div>
                    </div>
                </div>
            </article>
            <article id="search">
                <div class="container">
                    <div class="card type-column box-shadow-1">
                        <div class="card-title" style="background-color: rgba(0, 0, 0, 0.03)">
                            <p>Search</p>
                        </div>
                        <div class="card-content fw-400">
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Corrupti, eos! Cupiditate officia hic obcaecati at repudiandae iusto quidem unde laboriosam? Lorem ipsum dolor sit amet, consectetur adipisicing elit. Officiis placeat totam nihil! Vero, provident
                            sequi obcaecati ab quibusdam ad amet quisquam quia accusantium laudantium molestias tempora facere sit ut labore?
                        </div>
                    </div>
                </div>
            </article>

            <article id="advancedSearch">
                <div class="container">
                    <div class="card type-column box-shadow-1">
                        <div class="card-title" style="background-color: rgba(0, 0, 0, 0.03)">
                            <p>Advanced search</p>
                        </div>
                        <div class="card-content fw-400">
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Corrupti, eos! Cupiditate officia hic obcaecati at repudiandae iusto quidem unde laboriosam? Lorem ipsum dolor sit amet, consectetur adipisicing elit. Officiis placeat totam nihil! Vero, provident
                            sequi obcaecati ab quibusdam ad amet quisquam quia accusantium laudantium molestias tempora facere sit ut labore?
                        </div>
                    </div>
                </div>
            </article>
            <article id="communities">
                <div class="container">
                    <div class="card type-column box-shadow-1">
                        <div class="card-title" style="background-color: rgba(0, 0, 0, 0.03)">
                            <p id="communities">Communities</p>
                        </div>
                        <div class="card-content fw-400">
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Corrupti, eos! Cupiditate officia hic obcaecati at repudiandae iusto quidem unde laboriosam? Lorem ipsum dolor sit amet, consectetur adipisicing elit. Officiis placeat totam nihil! Vero, provident
                            sequi obcaecati ab quibusdam ad amet quisquam quia accusantium laudantium molestias tempora facere sit ut labore?
                        </div>
                    </div>
                </div>
            </article>

            <article id="collections">
                <div class="container">
                    <div class="card type-column box-shadow-1">
                        <div class="card-title" style="background-color: rgba(0, 0, 0, 0.03)">
                            <p>Collections</p>
                        </div>
                        <div class="card-content fw-400">
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Corrupti, eos! Cupiditate officia hic obcaecati at repudiandae iusto quidem unde laboriosam? Lorem ipsum dolor sit amet, consectetur adipisicing elit. Officiis placeat totam nihil! Vero, provident
                            sequi obcaecati ab quibusdam ad amet quisquam quia accusantium laudantium molestias tempora facere sit ut labore?
                        </div>
                    </div>
                </div>
            </article>
            <article id="signOn">
                <div class="container">
                    <div class="card type-column box-shadow-1">
                        <div class="card-title" style="background-color: rgba(0, 0, 0, 0.03)">
                            <p>Sign on to UCSC Digital Library</p>
                        </div>
                        <div class="card-content fw-400">
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Corrupti, eos! Cupiditate officia hic obcaecati at repudiandae iusto quidem unde laboriosam? Lorem ipsum dolor sit amet, consectetur adipisicing elit. Officiis placeat totam nihil! Vero, provident
                            sequi obcaecati ab quibusdam ad amet quisquam quia accusantium laudantium molestias tempora facere sit ut labore?
                        </div>
                    </div>

                </div>
            </article>
            <article id="submit">
                <div class="container">
                    <div class="card type-column box-shadow-1">
                        <div class="card-title" style="background-color: rgba(0, 0, 0, 0.03)">
                            <p>Submit</p>
                        </div>
                        <div class="card-content fw-400">
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Corrupti, eos! Cupiditate officia hic obcaecati at repudiandae iusto quidem unde laboriosam? Lorem ipsum dolor sit amet, consectetur adipisicing elit. Officiis placeat totam nihil! Vero, provident
                            sequi obcaecati ab quibusdam ad amet quisquam quia accusantium laudantium molestias tempora facere sit ut labore?
                        </div>
                    </div>
                </div>
            </article>
            <article id="fileFormat">
                <div class="container">
                    <div class="card type-column box-shadow-1">
                        <div class="card-title" style="background-color: rgba(0, 0, 0, 0.03)">
                            <p>File Formats</p>
                        </div>
                        <div class="card-content fw-400">
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Corrupti, eos! Cupiditate officia hic obcaecati at repudiandae iusto quidem unde laboriosam? Lorem ipsum dolor sit amet, consectetur adipisicing elit. Officiis placeat totam nihil! Vero, provident
                            sequi obcaecati ab quibusdam ad amet quisquam quia accusantium laudantium molestias tempora facere sit ut labore?
                        </div>
                    </div>
                </div>
            </article>
            <article id="editProfile">
                <div class="container">
                    <div class="card type-column box-shadow-1">
                        <div class="card-title" style="background-color: rgba(0, 0, 0, 0.03)">
                            <p>Edit Profile</p>
                        </div>
                        <div class="card-content fw-400">
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Corrupti, eos! Cupiditate officia hic obcaecati at repudiandae iusto quidem unde laboriosam? Lorem ipsum dolor sit amet, consectetur adipisicing elit. Officiis placeat totam nihil! Vero, provident
                            sequi obcaecati ab quibusdam ad amet quisquam quia accusantium laudantium molestias tempora facere sit ut labore?
                        </div>
                    </div>
                </div>
            </article>
        </div>
        <!-- FOOTER -->

        <?php include_once __DIR__ . '/components/footer.php'; ?>
    </div>

    <!-- SCRITP -->

    <script src="./javascript/nav.js"></script>

</body>

</html>