<!-- <?php

        use app\core\Application;

        $isLoggedIn = true;
        $userRole = "admin";
        ?> -->

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
    <link rel="stylesheet" href="/css/local-styles/user-approvals-report.css">
    <link rel="stylesheet" href="/css/local-styles/communities-admin-panel.css">

    <title>User Approvals Report</title>
</head>

<body>
    <?php
    include_once dirname(dirname(__DIR__)) . '/components/nav.php';
    ?>

    <div class="admin-dashboard-main-content">
        <div class="admin-dashboard-text">
            <p id='page-header-title'>User Approvals Report</p>

            <?php include_once dirname(dirname(__DIR__)) . '/components/breadcrum.php'; ?>
        </div>


        <?php
        $usersApproved = $params['userListA'] ?? false;
        $usersRejected = $params['userListR'] ?? false;
        $userData = $params['users'] ?? false;
        $approvedCount = $params['approvedCount'][0] ?? "";
        $rejectedCount = $params['rejectedCount'][0] ?? "";
        ?>

        <div class="details-container">
            <div class="data-container">
                <div class="tab-btn-container">
                    <a class="tab-link-btn blured" href="/admin/user-approvals-report/approvals">Approved Users(<?php echo $approvedCount; ?>)</a>
                    <a class="tab-link-btn active" href="/admin/user-approvals-report/rejections">Rejected Users (<?php echo $rejectedCount; ?>)</a>
                </div>
                <?php if ($usersRejected) { ?>
                    <div class="data-item-container edited-container">
                        <?php foreach ($usersRejected as $user) { ?>
                            <div class="data-item">
                                <p class="heading">User email: </p> <?= $user->email; ?></br>
                                <p class="heading">Rejected By:
                                    <?php foreach ($userData as $uData) {
                                        if ($user->approved_by == $uData->id) { ?>
                                <p><?= $uData->name ?></br>
                            <?php break;
                                        }
                                    } ?>
                            <?php if ($user->reason) { ?>
                                <p class="heading">Reason: </p><?= $user->reason; ?>
                            <?php } else { ?>
                                <p class="heading">Reason: </p>
                                <p class="n-a">N/A</p>
                            <?php } ?>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>
                <div class="data">

                    <?php if (empty($usersRejected)) { ?>
                        <div class="data-item-container">
                            <div class="data-item no-records">
                                <p class="no-records-available">No Records Available :(</p>
                            </div>
                        </div>
                    <?php } ?>
                </div>

                <?php
                if (!empty($usersRejected) && isset($params['pageCount'])) {
                    include_once dirname(dirname(__DIR__)) . '/components/paginate.php';
                }
                ?>

            </div>

            <div class="chart-container">
                <canvas id="myChart"></canvas>
            </div>
        </div>

    </div>

    <!-- FOOTER -->

    <?php
    include_once dirname(dirname(__DIR__)) . '/components/footer.php';
    ?>

    <!-- SCRIPT -->

    <script src="/javascript/nav.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.js" integrity="sha512-uLlukEfSLB7gWRBvzpDnLGvzNUluF19IDEdUoyGAtaO0MVSBsQ+g3qhLRL3GTVoEzKpc24rVT6X1Pr5fmsShBg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        const ctx = document.getElementById('myChart');
        var appoveCount = <?php echo json_encode($approvedCount); ?>;
        var rejectCount = <?php echo json_encode($rejectedCount); ?>;
        // for (var i = 0; i < userList.length; i++) {
        //     // document.write(userList[i]["is_approved"]);
        //     if (userList[i]["is_approved"] == 0) {
        //         rejectCount++;
        //     } else {
        //         appoveCount++;
        //     };
        //     // document.write(userList[i]["time"]);
        // }
        // document.write(appoveCount,rejectCount);
        var myChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Approved Users', 'Rejected Users'],
                datasets: [{
                    label: 'User approval status',
                    data: [appoveCount, rejectCount],
                    backgroundColor: [
                        'rgba(53, 252, 3, 0.7)',
                        'rgba(54, 162, 235, 0.7)'
                    ],
                    borderColor: [
                        'rgba(53, 252, 3, 1)',
                        'rgba(54, 162, 235, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                // scales: {
                //     y: {
                //         beginAtZero: true
                //     }
                // },
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'User Approval Status',
                        class: 'list-title'
                    }
                }
            }
        });
    </script>
</body>

</html>