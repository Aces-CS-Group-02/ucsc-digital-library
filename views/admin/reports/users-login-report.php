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
    <link rel="stylesheet" href="/css/local-styles/users-login-report.css">

    <title>Users' Login Report</title>
</head>

<body>

    <?php

    use app\core\Application;

    include_once dirname(dirname(__DIR__)) . '/components/nav.php';
    ?>

    <div class="admin-dashboard-main-content">
        <div class="admin-dashboard-text">
            <p id='page-header-title'>Users' Login Report</p>

            <?php include_once dirname(dirname(__DIR__)) . '/components/breadcrum.php'; ?>
        </div>

        <div class="wrapper">

            <?php
            $users = $params['userList'];
            $total = sizeof($users);
            date_default_timezone_set('Asia/Kolkata');
            $currentTime = date('Y-m-d H:i:s');
            // var_dump($currentTime);
            // var_dump($user->log_in_time);
            // var_dump(date_create($currentTime));
            $crntTime = date_create($currentTime);
            ?>

            <div class="search-N-sort-components-container">
                <div class="search-component-container">
                    <form action="" method="GET">
                        <div class="ug-search-input-wrapper">
                            <input type="text" placeholder="Search users" name='search-data' value="<?php echo $params['search_params'] ?? '' ?>"> 
                            <button>
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
                <div class="sort-component-container">
                    <p class="small-title">Total Users : <?php echo $params['resultCount']; ?></p>
                </div>
            </div>

            <div class="a-to-z-sort-main-container">
                <p id="a-to-z-sort-name">First Name: </p>
                <div class="a-to-z-sort-component-container">
                    <button class="a-to-z-sort-btn" id="a-to-z-all-btn">All</button>
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
                    <button class="a-to-z-sort-btn" id="a-to-z-all-btn">All</button>
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

            <div class="content-container">

                <div class="users-ud-headers-container">
                    <div class="block-a">First Name</div>
                    <div class="block-b">Last Name</div>
                    <!-- <div class="block-c">Email</div> -->
                    <div class="block-d">Role</div>
                    <div class="block-e">Last Access</div>
                </div>

                <div class="users-ud-container">
                    <?php foreach ($users as $user) { ?>
                        <div class="users-ud-info">
                            <div class="block-a">
                                <!-- <div class="block-title">
                                    <p>First Name</p>
                                    <p>:</p>
                                </div> -->
                                <p><?php echo $user->first_name; ?></p>
                            </div>
                            <div class="block-b">
                                <!-- <div class="block-title">
                                    <p>Last Name</p>
                                    <p>:</p>
                                </div> -->
                                <p><?php echo $user->last_name; ?></p>
                            </div>
                            <div class="block-d">
                                <!-- <div class="block-title">
                                    <p>Role</p>
                                    <p>:</p>
                                </div> -->
                                <p><span class="badge badge-soft-<?php if ($user->role_id == 1) echo "danger";
                                                                    else if ($user->role_id == 2) echo "warning";
                                                                    else if ($user->role_id == 3) echo "primary";
                                                                    else if ($user->role_id == 4) echo "success";
                                                                    else echo "secondary";
                                                                    ?>"><?php echo Application::$app->getUserRoleNameByID($user->role_id); ?></span></p>
                            </div>
                            <div class="block-e">
                                <!-- <div class="block-title">
                                    <p>Last Access Time</p>
                                    <p>:</p>
                                </div> -->
                                <?php
                                $logedTime = date_create($user->log_in_time);
                                $diff = $crntTime->diff($logedTime);
                                // echo '<pre>';
                                // var_dump($diff);
                                // echo '</pre>';
                                $y = $diff->y;
                                $mo = $diff->m;
                                $d = $diff->d;
                                $h = $diff->h;
                                $m = $diff->i;
                                $s = $diff->s;
                                ?>
                                <p><?php
                                // var_dump($user->log_in_time);
                                    if ($user->log_in_time != '0000-00-00 00:00:00') {
                                        if ($y) {
                                            if ($y == 1) {
                                                if ($mo == 1) {
                                                    echo ($y . ' year ' . $mo . ' month');
                                                } elseif ($d) {
                                                    echo ($y . ' year ' . $mo . ' months');
                                                } else {
                                                    echo ($y . ' year');
                                                }
                                            } elseif ($mo == 1) {
                                                echo ($y . ' years ' . $mo . ' month');
                                            } elseif ($mo) {
                                                echo ($y . ' years ' . $mo . ' months');
                                            } else {
                                                echo ($y . ' years');
                                            }
                                        } elseif ($mo) {
                                            if ($mo == 1) {
                                                if ($d == 1) {
                                                    echo ($mo . ' month ' . $d . ' day');
                                                } elseif ($d) {
                                                    echo ($mo . ' month ' . $d . ' days');
                                                } else {
                                                    echo ($mo . ' month');
                                                }
                                            } elseif ($d == 1) {
                                                echo ($mo . ' months ' . $d . ' day');
                                            } elseif ($d) {
                                                echo ($mo . ' months ' . $d . ' days');
                                            } else {
                                                echo ($mo . ' months');
                                            }
                                        } else {
                                            if ($d == 1) {
                                                if ($h == 1) {
                                                    echo ($d . ' day ' . $h . ' hour');
                                                } elseif ($h) {
                                                    echo ($d . ' day ' . $h . ' hours');
                                                } else {
                                                    echo ($d . ' day');
                                                }
                                            } elseif ($d) {
                                                if ($h == 1) {
                                                    echo ($d . ' days ' . $h . ' hour');
                                                } elseif ($h) {
                                                    echo ($d . ' days ' . $h . ' hours');
                                                } else {
                                                    echo ($d . ' days');
                                                }
                                            } else {
                                                if ($h == 1) {
                                                    echo ($h . ' hour');
                                                } elseif ($h) {
                                                    echo ($h . ' hours');
                                                } else {
                                                    if ($m < 1) {
                                                        echo ($s . ' seconds');
                                                    } elseif ($m == 1) {
                                                        echo ($m . ' minute');
                                                    } else {
                                                        echo ($m . ' minutes');
                                                    }
                                                }
                                            }
                                        }
                                    } else {
                                        echo ('Never');
                                    }
                                    ?></p>
                            </div>
                        </div>
                    <?php } ?>
                </div>

                <?php

                if (!empty($users) && isset($params['pageCount'])) {
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

    <!-- SCRIPT -->

    <script src="/javascript/nav.js"></script>

</body>

</html>