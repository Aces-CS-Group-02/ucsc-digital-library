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
    <link rel="stylesheet" href="/css/local-styles/verify-new-users.css">


    <title>Approve New Users Information</title>
</head>

<body>

    <!-- NAVIGATION BAR -->

    <?php
    include_once dirname(dirname(__DIR__)) . '/components/nav.php';
    ?>

    <?php
    $newUser = $params['model'];
    ?>



    <div class="info-dashboard-main-content">
        <div class="admin-dashboard-text">
            <p id="page-header-title">Approve New User </p>
            <?php include_once dirname(dirname(__DIR__)) . '/components/breadcrum.php'; ?>
        </div>


        <div class="table-responsive table-margin">
            <div class="btn-grid-container">
                <div class="btn-container">
                    <!-- <form action="/admin/approve-new-user/view" method="GET">
                        <button class="btn btn-success mr-1 mb-1 btn2-edit" onclick="showModal(true,this,<?= $id ?>,'<?= $fName ?>','<?= $lName ?>')" type="button">Approve</button>
                        <button class="btn btn-danger mr-1 mb-1 btn3-edit" onclick="showModal(false,this,<?= $id ?>,'<?= $fName ?>','<?= $lName ?>')" type="button">Reject</button>
                    </form> -->
                </div>
                <div class="info-items-container">


                    <!-- ID -->

                    <div class="info-item-container first-node">
                        <div class="info-item-title">
                            <p>ID:</p>
                        </div>
                        <div class="info-item-content">
                            <p><?php echo $newUser->request_id ?></p>
                        </div>
                    </div>

                    <!-- first name -->
                    <div class="info-item-container ">
                        <div class="info-item-title">
                            <p>First Name:</p>
                        </div>
                        <div class="info-item-content">
                            <p><?php echo $newUser->first_name ?></p>
                        </div>
                    </div>

                    <!-- last name -->
                    <div class="info-item-container ">
                        <div class="info-item-title">
                            <p>Last Name:</p>
                        </div>
                        <div class="info-item-content">
                            <p><?php echo $newUser->last_name ?></p>
                        </div>
                    </div>


                    <!-- email -->
                    <div class="info-item-container">
                        <div class="info-item-title">
                            <p>User Email:</p>
                        </div>
                        <div class="info-item-content">
                            <p><?php echo $newUser->email ?></p>
                        </div>
                    </div>

                    <!-- verification -->
                    <div class="info-item-container last">
                        <div class="info-item-title">
                            <p>NIC:</p>
                        </div>
                        <div class="info-item-content ">
                            <img src="http://localhost:8000/<?php echo $newUser->verification; ?>" alt="nic-image" style='width:400px;height:400px'>
                        </div>
                    </div>

                    <!-- message -->
                    <div class="info-item-container">
                        <div class="info-item-title">
                            <p>Message:</p>
                        </div>
                        <div class="info-item-content">

                            <p class="line-clamp line-clamp-1-description"><?php
                                                                            if ($newUser->message === "") {
                                                                                echo "N/A";
                                                                            } else {
                                                                                echo $newUser->message;
                                                                            }  ?></p>
                        </div>
                    </div>

                    <!-- Date -->
                    <div class="info-item-container ">
                        <div class="info-item-title">
                            <p>Date:</p>
                        </div>
                        <div class="info-item-content">
                            <p><?php
                                $date = new DateTime($newUser->date);
                                echo $date->format('Y-m-d'); ?></p>
                        </div>

                    </div>


                </div>
            </div>
        </div>

        <div id="myModal" class="modal">

            <div class="modal-content" id="modal-content">
                <form id="modal-form" action="" method="POST">
                    <div class="modal-top-section modal-title">
                        <div class="title-section">
                            <p id="mtitle"></p>
                            <div id="break-modal-title">
                                <p id="FName"></p>
                                <p id="LName"></p>
                            </div>
                        </div>
                        <div class="close">
                            <span class="edit-close">&times;</span>
                        </div>
                    </div>
                    <div class="input-group edit-input-group">
                        <input type="textarea" class="form-control edit-form-control" id="reason" name="reason" placeholder="Enter the reason"></input>
                    </div>
                    <div class="modal-bottom-section">
                        <button class="btn btn-info mr-1 mb-1" name="request_id" id="idOut" type="submit">Okay</button>
                    </div>
                </form>
            </div>

        </div>

    </div>

    <!-- FOOTER -->

    <?php
    include_once dirname(dirname(__DIR__)) . '/components/footer.php';
    ?>
    <script src="/javascript/nav.js"></script>
    <script src="/javascript/verify-new-users.js"></script>

</body>

</html>