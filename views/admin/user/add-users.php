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
            <p id="page-header-title">Add Users | <?php echo $params['group']->name ?? "" ?></p>
        </div>

        <div class="wrapper">

            <div class="second-border">

                <div class="upper-container">
                    <div class="button-place">
                        <form action="/admin/create-user-group/review" method="POST">

                            <button class="btn btn-primary mr-1 mb-1" id="btn-edit" disabled>Proceed</button>
                        </form>
                    </div>
                </div>

                <div class="search-N-sort-components-container">
                    <div class="search-component-container">
                        <form action="">
                            <div class="ug-search-input-wrapper">
                                <input type="text" placeholder="Search user groups">
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
                <form action="">
                    <button class="btn btn-danger mr-1 mb-1 btn2-edit" type="button" id="bulk-add-btn">Add</button>
                </form>
            </div>

            <!-- ADD USERS INFORMATION -->

            <div class="content-container">

                <div class="add-users-headers-container">
                    <div class="block-a"> </div>
                    <div class="block-b">First Name</div>
                    <div class="block-c">Last Name</div>
                    <div class="block-d">Email</div>
                    <div class="block-f">Action</div>
                </div>

                <?php foreach ($params['users_list'] as $student) { ?>
                    <div class="add-users-container">
                        <div class="add-users-info">
                            <div class="block-a">
                                <p>
                                <div class="input-group custom-control">
                                    <div class="checkbox checkbox-edit">
                                        <input class="checkbox checkbox-edit" data-id="<?php echo $student->reg_no; ?>" type="checkbox" id="check" onclick="DivShowHide(this)" />
                                    </div>
                                </div>
                                </p>
                            </div>
                            <div class="block-b">
                                <div class="block-title">
                                    <p>First Name</p>
                                    <p>:</p>
                                </div>
                                <p><?php echo $student->first_name ?></p>
                            </div>
                            <div class="block-c">
                                <div class="block-title">
                                    <p>Last Name</p>
                                    <p>:</p>
                                </div>
                                <p><?php echo $student->last_name ?></p>
                            </div>
                            <div class="block-d">
                                <div class="block-title">
                                    <p>Email</p>
                                    <p>:</p>
                                </div>
                                <p><?php echo $student->email ?></p>
                            </div>

                            <div class="block-f">
                                <p>
                                    <button class="btn btn-add" type="button" data-id="<?php echo $student->reg_no; ?>">Add</button>
                                </p>
                            </div>
                        </div>
                    </div>
                <?php } ?>



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
            const deleteBtns = document.querySelectorAll('.btn-add');
            const checkBoxes = document.querySelectorAll('#check')
            const bulkAddbtn = document.getElementById('bulk-add-btn');
            const rows = document.querySelectorAll('.add-users-info');

            const ID_MAP = new WeakMap();
            const ID_MAP_2 = new WeakMap();
            let users = [];

            const handleAdd = ({
                currentTarget
            }) => {
                // Exit if there is no ID stored
                if (!ID_MAP.has(currentTarget)) return;

                // Retrieve and log ID
                const id = ID_MAP.get(currentTarget);
                console.log(ID_MAP[id]);
                console.log(id);

                // AJAX request
                var http = new XMLHttpRequest();
                var url = '/ajax/push-user-to-user-group';
                var params = `usergroup_id=<?php echo $params['group']->group_id ?>&reg_no_list=${id}`;
                http.open('POST', url, true);
                http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                http.onreadystatechange = function() {
                    if (http.readyState == 4 && http.status == 200) {
                        if (this.responseText === 'success') {
                            console.log(currentTarget.parentElement)
                        }
                    }
                }
                http.send(params);
            }

            // ==========================================================

            for (const btn of deleteBtns) {
                // Skip if it doesn't have an ID
                if (!btn.dataset.id) continue;
                // Store and hide `data-id` attribute
                ID_MAP.set(btn, btn.dataset.id);
                btn.removeAttribute('data-id');
                // Add event listener
                btn.addEventListener('click', handleAdd, false);
            }


            // ==============================================================

            const handleBulkAdd = () => {
                const users_list = [];
                for (const check of checkBoxes) {
                    if (check.checked) {
                        users_list.push(check.dataset.id);
                    }
                }
                console.log(users_list);

                // AJAX request
                var http = new XMLHttpRequest();
                var url = '/ajax/push-users-to-user-group';
                var params = `usergroup_id=<?php echo $params['group']->group_id ?>&reg_no_list=${users_list}`;
                http.open('POST', url, true);
                http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                http.onreadystatechange = function() {
                    if (http.readyState == 4 && http.status == 200) {
                        console.log("Done");
                    }
                }
                http.send(params);
            }

            bulkAddbtn.addEventListener('click', handleBulkAdd, false);





        })();
    </Script>


</body>

</html>