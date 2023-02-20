<?php
session_start();
$location = "login.php";
if (isset($_SESSION['user_name'])) {
    $user_name = $_SESSION['user_name'];
    $user_id = $_SESSION['user_id'];
} else {
    header("Location:$location");
    exit;
}
include_once 'db.php';

if (isset($_POST['task_name'])) {

    $task_name = mysqli_real_escape_string($conn, (htmlspecialchars($_POST['task_name'])) ? htmlspecialchars($_POST['task_name']) : $_POST['task_name']);

    $sql = "INSERT INTO `task_master` SET `task_name` ='$task_name' , `user_id` = $user_id";
    $result = mysqli_query($conn, $sql) or trigger_error("Query Failed! SQL: $sql - Error: " . mysqli_error($conn));
//    $sqlmax = "SELECT SCOPE_IDENTITY()";
    $sqlmax = "SELECT `id` as `max_id`,`task_name` FROM `task_master` WHERE `id` = (SELECT MAX(`id`) FROM `task_master` )";
    $resultmax = mysqli_query($conn, $sqlmax) or trigger_error("Query Failed! SQL: $sqlmax - Error: " . mysqli_error($conn));
    while ($rowmax = mysqli_fetch_assoc($resultmax)) {
        $max_id = $rowmax['max_id'];
        $max_task_name = $rowmax['task_name'];
    }

    ?>
    <li class="taskboard-stage" draggable="true" id="main_box<?php echo $max_id; ?>">
        <header class="taskboard-stage-header ui-sortable-handle">
            <div class="taskboard-stage-actions float-right">
                <div class="dropdown">
                    <a data-toggle="dropdown" href="#" aria-expanded="false"><i class="icon md-chevron-down"
                                                                                aria-hidden="true"></i></a>
                    <div class="dropdown-menu bullet" role="menu">
                        <a class="taskboard-stage-rename dropdown-item" id="rename_click--<?php echo $max_id; ?>"
                           href="javascript:void(0)"
                           role="menuitem"><i class="icon md-edit" aria-hidden="true"></i>Rename</a>
                        <a class="taskboard-stage-delete dropdown-item delete_main"
                           id="delete_main--<?php echo $max_id; ?>"
                           href="javascript:void(0)" role="menuitem"><i class="icon md-delete" aria-hidden="true"></i>Delete
                            List</a>
                        <div class="taskboard-stage-rename-wrap" id="rename_show<?php echo $max_id; ?>">
                            <div class="form-group">
                                <input class="form-control taskboard-stage-rename-input" type="text"
                                       value="<?php echo $max_task_name; ?>"
                                       id="rename<?php echo $max_id; ?>">
                            </div>
                            <button class="btn btn-primary btn-block save_rename taskboard-stage-rename-save waves-effect waves-classic"
                                    id="save_rename--<?php echo $max_id; ?>" type="button">
                                Save
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <h5 class="taskboard-stage-title" id="task_head<?php echo $max_id; ?>"><?php echo $max_task_name; ?></h5>
        </header>
        <div class="taskboard-stage-content">
            <ul class="list-group taskboard-list ui-sortable">
            </ul>
            <div class="action-wrap">
                <a id="sub_task--<?php echo $max_id; ?>" class="sub_task add-item-toggle" href="#"><i
                            class="icon md-plus"
                            aria-hidden="true"></i>Add Task</a>
                <div class="add-item-wrap show_task_name" id="show_task_name<?php echo $max_id; ?>">
                    <div class="form-group">
                        <label class="form-control-label mb-15" for="name">Task name:</label>
                        <input class="form-control sub_task_name" id="sub_task_name<?php echo $max_id; ?>" type="text"
                               placeholder="Sub Task name" name="sub_task_name">
                    </div>
                    <div class="form-group text-right">
                        <a id="cancel_sub_task<?php echo $max_id; ?>"
                           class="btn btn-sm btn-white btn-pure add-item-cancel waves-effect waves-classic">Cancel</a>
                        <button type="button" id="add_sub_task<?php echo $max_id; ?>"
                                class="btn btn-primary add-item-add waves-effect waves-classic">Add
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </li>
    <?php
    exit;
}
if (isset($_POST['rename'])) {
    $rename = mysqli_real_escape_string($conn, (htmlspecialchars($_POST['rename'])) ? htmlspecialchars($_POST['rename']) : $_POST['rename']);

    $main_task_id = $_POST['main_task_id'];

    $sqlr = "UPDATE `task_master` SET `task_name` ='$rename' WHERE `id` = '$main_task_id'";
    $resultr = mysqli_query($conn, $sqlr) or trigger_error("Query Failed! SQL: $sqlr - Error: " . mysqli_error($conn));
    echo $rename;
    exit;
}
if (isset($_POST['rename_sub'])) {
    $rename_sub = mysqli_real_escape_string($conn, (htmlspecialchars($_POST['rename_sub'])) ? htmlspecialchars($_POST['rename_sub']) : $_POST['rename_sub']);

    $sub_rename_id = $_POST['sub_rename_id'];

    $sqlrns = "UPDATE `sub_task` SET `sub_task_name` ='$rename_sub' WHERE `id` = '$sub_rename_id'";
    $resultrns = mysqli_query($conn, $sqlrns) or trigger_error("Query Failed! SQL: $sqlrns - Error: " . mysqli_error($conn));
    echo $rename_sub;
    exit;
}
if (isset($_POST['last_date_id'])) {

    $last_date1 = $_POST['last_date'];
    $last_date_id = $_POST['last_date_id'];
    $last_date = date("Y-m-d", strtotime($last_date1));

    $sqlld = "UPDATE `sub_task` SET `last_date` ='$last_date' WHERE `id` = '$last_date_id'";
    $resultld = mysqli_query($conn, $sqlld) or trigger_error("Query Failed! SQL: $sqlld - Error: " . mysqli_error($conn));
//    echo $last_date;
    exit;
}

if (isset($_POST['sub_task_name'])) {
    $sub_task_name = mysqli_real_escape_string($conn, (htmlspecialchars($_POST['sub_task_name'])) ? htmlspecialchars($_POST['sub_task_name']) : $_POST['sub_task_name']);

    $main_task_id = $_POST['main_task_id'];
    $sqlsub = "INSERT INTO `sub_task` SET `sub_task_name` ='$sub_task_name' , `main_task_id` =  '$main_task_id' , `user_id` = $user_id";
    $resultsub = mysqli_query($conn, $sqlsub) or trigger_error("Query Failed! SQL: $sqlsub - Error: " . mysqli_error($conn));

    $sqlmaxs = "SELECT `id` as `max_id`,`sub_task_name` FROM `sub_task` WHERE `id` = (SELECT MAX(`id`) FROM `sub_task` )";
    $resultmaxs = mysqli_query($conn, $sqlmaxs) or trigger_error("Query Failed! SQL: $sqlmaxs - Error: " . mysqli_error($conn));
    while ($rowmaxs = mysqli_fetch_assoc($resultmaxs)) {
        $max_ids = $rowmaxs['max_id'];
        $max_task_names = $rowmaxs['sub_task_name'];
    }

    ?>
    <li class="list-group-item sub_list" id="sub_list<?php echo $max_ids; ?>" data-taskboard="slidePanel"
        data-url="panel.tpl">
        <div class="checkbox-custom checkbox-primary">
            <input type="checkbox" class="add_to_complete" id="add_to_complete--<?php echo $max_ids; ?>"
                   name="checkbox">
            <label class="task-title"><?php echo $max_task_names; ?></label><br><br>
            <div class="row">
                <div class="col-md-6">
                    <input type="checkbox" class="add_to_urgent"
                           id="add_to_urgent--<?php echo $max_ids; ?>"
                           name="checkbox" <?php if ($rowmaxs['is_urgent'] == 1){ ?>checked="checked" <?php } ?>>
                    <label class="task-title"
                           <?php if ($rowmaxs['is_urgent'] == 1){ ?>style="text-decoration: underline;color:red;" <?php } ?>>
                        <?php if ($rowmaxs['is_urgent'] == 1) {
                            echo 'Urgent';
                        } else {
                            echo 'Not Urgent';
                        } ?></label>


                </div>
                <div class="col-md-6">
                    <input type="checkbox" class="add_to_important"
                           id="add_to_important--<?php echo $max_ids; ?>"
                           name="checkbox" <?php if ($rowmaxs['is_important'] == 1){ ?>checked="checked" <?php } ?>>
                    <label class="task-title"
                           <?php if ($rowmaxs['is_important'] == 1){ ?>style="text-decoration: underline;color:#00A751;" <?php } ?>>
                        <?php if ($rowmaxs['is_important'] == 1) {
                            echo 'Important';
                        } else {
                            echo 'Not Important';
                        } ?></label>


                </div>
            </div>
            <header class="">
                <div class="taskboard-stage-actions float-right">
                    <div class="dropdown" style="margin-top: -65px;">
                        <a data-toggle="dropdown" href="#" aria-expanded="false">
                            <div class="sub_menu" style="float: right">
                                <div class="m"></div>
                                <div class="m"></div>
                                <div class="m"></div>
                            </div>
                        </a>
                        <div class="dropdown-menu bullet" id="sub_menu_box<?php echo $max_ids; ?>" role="menu">
                            <a class=" dropdown-item rename_sub"
                               id="rename_sub--<?php echo $max_ids . '--' . $max_ids; ?>"
                               href="javascript:void(0)"
                               role="menuitem"><i class="icon md-edit"
                                                  aria-hidden="true"></i>Rename</a>
                            <a class="taskboard-stage-rename dropdown-item dublicate_sub"
                               id="dublicate_sub--<?php echo $max_ids; ?>--<?php echo $main_task_id; ?>"
                               href="javascript:void(0)" role="menuitem"><i class="icon md-copy" aria-hidden="true"></i>Duplicate
                                Task</a>
                            <a class="taskboard-stage-delete delete_sub dropdown-item"
                               id="delete_sub--<?php echo $max_ids; ?>" href="javascript:void(0)" role="menuitem"><i
                                        class="icon md-delete" aria-hidden="true"></i>Delete</a>
                        </div>

                    </div>
                </div>
            </header>
        </div>
        <div class="w-full">
            <div class="task-badges">
                <div class="clickable-text daterange__picker daterange__picker--start_date">
                    <input type="text" name="start_date">
                    <span class="btn"
                          style="border-radius: 40px;color: rgb(24, 144, 255);width: 150px;height: 35px;margin: 25px 0px 15px -145px;"
                          id="last_date--<?php echo $max_ids; ?>">

                    <span class="task-badge task-badge-subtask icon md-calendar"></span></span>
                </div>
            </div>

        </div>
    </li>
    <?php
    exit;
}
if (isset($_POST['add_to_complete'])) {
    $cid = $_POST['add_to_complete'];
    $sqlc = "UPDATE `sub_task` SET `is_complete` ='1' WHERE `id` = '$cid'";
    $resultc = mysqli_query($conn, $sqlc) or trigger_error("Query Failed! SQL: $sqlc - Error: " . mysqli_error($conn));

//    echo $cid .'done done';
    exit;
}
if (isset($_POST['add_to_urgent'])) {
    $uid = $_POST['add_to_urgent'];
    $sqluu = "SELECT `is_urgent` FROM `sub_task` WHERE `id` = '$uid'";
    $resultuu = mysqli_query($conn, $sqluu) or trigger_error("Query Failed! SQL: $sqluu - Error: " . mysqli_error($conn));
    while ($rowuu = mysqli_fetch_assoc($resultuu)) {
        $is_urgent = $rowuu['is_urgent'];
    }
    if ($is_urgent == 1) {
        $sqlu = "UPDATE `sub_task` SET `is_urgent` ='0' WHERE `id` = '$uid'";
        $resultu = mysqli_query($conn, $sqlu) or trigger_error("Query Failed! SQL: $sqlu - Error: " . mysqli_error($conn));

    } else {
        $sqlu = "UPDATE `sub_task` SET `is_urgent` ='1' WHERE `id` = '$uid'";
        $resultu = mysqli_query($conn, $sqlu) or trigger_error("Query Failed! SQL: $sqlu - Error: " . mysqli_error($conn));

    }


//    echo $cid .'done done';
    exit;
}
if (isset($_POST['add_to_important'])) {
    $iid = $_POST['add_to_important'];

    $sqlii = "SELECT `is_important` FROM `sub_task` WHERE `id` = '$iid'";
    $resultii = mysqli_query($conn, $sqlii) or trigger_error("Query Failed! SQL: $sqlii - Error: " . mysqli_error($conn));
    while ($rowii = mysqli_fetch_assoc($resultii)) {
        $is_important = $rowii['is_important'];
    }
    if ($is_important == 1) {
        $sqli = "UPDATE `sub_task` SET `is_important` ='0' WHERE `id` = '$iid'";
        $resulti = mysqli_query($conn, $sqli) or trigger_error("Query Failed! SQL: $sqli - Error: " . mysqli_error($conn));

    } else {
        $sqli = "UPDATE `sub_task` SET `is_important` ='1' WHERE `id` = '$iid'";
        $resulti = mysqli_query($conn, $sqli) or trigger_error("Query Failed! SQL: $sqli - Error: " . mysqli_error($conn));

    }


//    echo $cid .'done done';
    exit;
}
if (isset($_POST['remove_from_complete'])) {
    $rid = $_POST['remove_from_complete'];
    $sqlr = "UPDATE `sub_task` SET `is_complete` ='0' WHERE `id` = '$rid'";
    $resultr = mysqli_query($conn, $sqlr) or trigger_error("Query Failed! SQL: $sqlr - Error: " . mysqli_error($conn));

    exit;
}
if (isset($_POST['delete_sub'])) {
    $dsid = $_POST['delete_sub'];
    $sqlds = "DELETE FROM `sub_task` WHERE `id` = '$dsid'";
    $resultds = mysqli_query($conn, $sqlds) or trigger_error("Query Failed! SQL: $sqlds - Error: " . mysqli_error($conn));

    exit;
}
if (isset($_POST['delete_main'])) {
    $dmid = $_POST['delete_main'];
    $sqldm = "DELETE FROM `task_master` WHERE `id` = '$dmid'";
    $resultdm = mysqli_query($conn, $sqldm) or trigger_error("Query Failed! SQL: $sqldm - Error: " . mysqli_error($conn));

    $sqldls = "DELETE FROM `sub_task` WHERE `main_task_id` = '$dmid'";
    $resultdls = mysqli_query($conn, $sqldls) or trigger_error("Query Failed! SQL: $sqldls - Error: " . mysqli_error($conn));

    exit;
}
if (isset($_POST['delete_completed'])) {
    $dcid = $_POST['delete_completed'];

    $sqldc = "DELETE FROM `sub_task` WHERE `is_complete` = '1' AND `main_task_id` = '$dcid'";
    $resultdls = mysqli_query($conn, $sqldc) or trigger_error("Query Failed! SQL: $sqldc - Error: " . mysqli_error($conn));

    exit;
}
if (isset($_POST['duplicate_main'])) {
    $ex_main_id = $_POST['duplicate_main'];

    $sqlexm = "SELECT `task_name` FROM `task_master` WHERE `id` = '$ex_main_id'";
    $resultexm = mysqli_query($conn, $sqlexm) or trigger_error("Query Failed! SQL: $sqlexm - Error: " . mysqli_error($conn));

    while ($rowexs = mysqli_fetch_assoc($resultexm)) {
        $exmain_task_name1 = $rowexs['task_name'];
    }
    $exmain_task_name = mysqli_real_escape_string($conn, (htmlspecialchars($exmain_task_name1)) ? htmlspecialchars($exmain_task_name1) : $exmain_task_name1);

    $sqldubm = "INSERT INTO `task_master` SET `task_name` ='$exmain_task_name', `user_id` = '$user_id'";
    $resultdubm = mysqli_query($conn, $sqldubm) or trigger_error("Query Failed! SQL: $sqldubm - Error: " . mysqli_error($conn));

    $sqlmax1 = "SELECT `id` as `max_id`,`task_name` FROM `task_master` WHERE `id` = (SELECT MAX(`id`) FROM `task_master` )";
    $resultmax1 = mysqli_query($conn, $sqlmax1) or trigger_error("Query Failed! SQL: $sqlmax1 - Error: " . mysqli_error($conn));
    while ($rowmax1 = mysqli_fetch_assoc($resultmax1)) {
        $max_id1 = $rowmax1['max_id'];
//        $max_task_name1 = $rowmax1['task_name'];
    }

    $sqlexs = "SELECT * FROM `sub_task` WHERE `main_task_id` = '$ex_main_id'";
//    echo $sqlexs;exit;
    $resultexs = mysqli_query($conn, $sqlexs) or trigger_error("Query Failed! SQL: $sqlexs - Error: " . mysqli_error($conn));
    while ($rowexs = mysqli_fetch_assoc($resultexs)) {
        $exsub_task_name1 = $rowexs['sub_task_name'];
        $exsub_task_name = mysqli_real_escape_string($conn, (htmlspecialchars($exsub_task_name1)) ? htmlspecialchars($exsub_task_name1) : $exsub_task_name1);

        $exis_urgent = $rowexs['is_urgent'];
        $exis_important = $rowexs['is_important'];
        $exlast_date = $rowexs['last_date'];
        $sqldubs = "INSERT INTO `sub_task` SET `sub_task_name` ='$exsub_task_name', `is_urgent` = '$exis_urgent',
 `is_important` = '$exis_important' ,`last_date` = '$exlast_date' , `main_task_id` =  '$max_id1',
  `user_id` = $user_id ";
//echo $sqldubs;
        $resultdubs = mysqli_query($conn, $sqldubs) or trigger_error("Query Failed! SQL: $sqldubs - Error: " . mysqli_error($conn));

    }

    exit;
}
if (isset($_POST['dublicate_sub'])) {
    $exid = $_POST['dublicate_sub'];
    $main_id = $_POST['main_id'];
    $sqlexs = "SELECT * FROM `sub_task` WHERE `id` = '$exid'";
    $resultexs = mysqli_query($conn, $sqlexs) or trigger_error("Query Failed! SQL: $sqlexs - Error: " . mysqli_error($conn));
    while ($rowexs = mysqli_fetch_assoc($resultexs)) {
        $exsub_task_name = $rowexs['sub_task_name'];
        $exis_urgent = $rowexs['is_urgent'];
        $exis_important = $rowexs['is_important'];
        $exlast_date = $rowexs['last_date'];
    }
    $sqldubs = "INSERT INTO `sub_task` SET `sub_task_name` ='$exsub_task_name', `is_urgent` = '$exis_urgent', `is_important` = '$exis_important' ,`last_date` = '$exlast_date' , `main_task_id` =  '$main_id', `user_id` = $user_id";
    $resultdubs = mysqli_query($conn, $sqldubs) or trigger_error("Query Failed! SQL: $sqldubs - Error: " . mysqli_error($conn));

    exit;
}
?>
<!DOCTYPE html>
<html class="no-js css-menubar" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="bootstrap material admin template">
    <meta name="author" content="">

    <title>Nithra | Task Board</title>

    <link rel="apple-touch-icon" href="material/iconbar/assets/images/apple-touch-icon.png">
    <link rel="shortcut icon" href="https://getbootstrapadmin.com/remark/material/iconbar/assets/images/favicon.ico">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="material/global/css/bootstrap.minfd53.css?v4.0.1">
    <link rel="stylesheet" href="material/global/css/bootstrap-extend.minfd53.css?v4.0.1">
    <link rel="stylesheet" href="material/iconbar/assets/css/site.minfd53.css?v4.0.1">

    <!-- Skin tools (demo site only) -->
    <link rel="stylesheet" href="material/global/css/skintools.minfd53.css?v4.0.1">
    <script src="material/iconbar/assets/js/Plugin/skintools.minfd53.js?v4.0.1"></script>

    <!-- Plugins -->
    <link rel="stylesheet" href="material/global/vendor/animsition/animsition.minfd53.css?v4.0.1">
    <link rel="stylesheet" href="material/global/vendor/asscrollable/asScrollable.minfd53.css?v4.0.1">
    <link rel="stylesheet" href="material/global/vendor/switchery/switchery.minfd53.css?v4.0.1">
    <link rel="stylesheet" href="material/global/vendor/intro-js/introjs.minfd53.css?v4.0.1">
    <link rel="stylesheet" href="material/global/vendor/slidepanel/slidePanel.minfd53.css?v4.0.1">
    <link rel="stylesheet" href="material/global/vendor/flag-icon-css/flag-icon.minfd53.css?v4.0.1">
    <link rel="stylesheet" href="material/global/vendor/waves/waves.minfd53.css?v4.0.1">

    <!-- Plugins For This Page -->
    <link rel="stylesheet" href="material/global/vendor/bootstrap-select/bootstrap-select.minfd53.css?v4.0.1">
    <link rel="stylesheet" href="material/global/vendor/jquery-selective/jquery-selective.minfd53.css?v4.0.1">
    <!--    <link rel="stylesheet" href="material/global/vendor/bootstrap-datepicker/bootstrap-datepicker.minfd53.css?v4.0.1">-->
    <link rel="stylesheet" href="material/global/vendor/bootstrap-markdown/bootstrap-markdown.minfd53.css?v4.0.1">

    <!-- Page -->
    <link rel="stylesheet" href="material/iconbar/assets/examples/css/apps/taskboard.minfd53.css?v4.0.1">

    <!-- Fonts -->
    <link rel="stylesheet" href="material/global/fonts/material-design/material-design.minfd53.css?v4.0.1">
    <link rel="stylesheet" href="material/global/fonts/brand-icons/brand-icons.minfd53.css?v4.0.1">
    <link rel='stylesheet' href="https://fonts.googleapis.com/css?family=Roboto:400,400italic,700">

    <link rel="stylesheet" href="material/global/fonts/font-awesome/font-awesome.minfd53.css?v4.0.1">
    <!--    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.0/jquery-ui.css">

    <!--[if lt IE 9]>
    <script src="material/global/vendor/html5shiv/html5shiv.min.js?v4.0.1"></script>
    <![endif]-->

    <!--[if lt IE 10]>
    <script src="material/global/vendor/media-match/media.match.min.js?v4.0.1"></script>
    <script src="material/global/vendor/respond/respond.min.js?v4.0.1"></script>
    <![endif]-->

    <!-- Scripts -->
    <script src="material/global/vendor/breakpoints/breakpoints.minfd53.js?v4.0.1"></script>
    <script>
        Breakpoints();
    </script>
    <style>
        .m {
            width: 4px;
            height: 4px;
            background-color: #957f7f;
            margin: 0px 0px 1px 0px;
            border-radius: 50%;
            /*margin-left: 187px;*/
        }

        .daterange__picker {
            position: relative;
        }

        .daterange__picker input {
        / / invisible input as jquery ui requires an actual input position: absolute;
            left: 0;
            bottom: 0;
            opacity: 0;

            pointer-events: none;
        }

        .taskboard-stage {
            width: 300px !important;
        }

        .clickable-text {
            display: inline-block;
            /*border-bottom: 2px dotted #ccc;*/
            user-select: none;

            cursor: pointer;
            padding: 0 2px;

            color: #000;

        &
        :hover {
            color: blue;
            background: #f5f5f5;
            border-bottom-color: blue;
        }

        }
        .taskboard-list .list-group-item .task-badge {
            margin-top: -3px;
            margin-left: 50px;
            /*margin: 31px 0px 13px 100px;*/
            width: 5px;
            font-size: 20px;
        }

    </style>
</head>
<body class="animsition app-taskboard">
<!--[if lt IE 8]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade
    your browser</a> to improve your experience.</p>
<![endif]-->

<nav class="site-navbar navbar navbar-default navbar-inverse navbar-fixed-top navbar-mega"
     role="navigation">

    <div class="navbar-header">
        <button type="button" class="navbar-toggler hamburger hamburger-close navbar-toggler-left hided"
                data-toggle="menubar">
            <span class="sr-only">Toggle navigation</span>
            <span class="hamburger-bar"></span>
        </button>
        <button type="button" class="navbar-toggler collapsed" data-target="#site-navbar-collapse"
                data-toggle="collapse">
            <i class="icon md-more" aria-hidden="true"></i>
        </button>
        <div class="navbar-brand navbar-brand-center">
            <img class="navbar-brand-logo" src="https://nithra.mobi/assets/images/nithra_logo_1.svg" title="Remark">
            <!--            <span class="navbar-brand-text hidden-xs-down">Nithra</span>-->
        </div>
        <button type="button" class="navbar-toggler collapsed" data-target="#site-navbar-search"
                data-toggle="collapse">
            <span class="sr-only">Toggle Search</span>
            <i class="icon md-search" aria-hidden="true"></i>
        </button>
    </div>

    <div class="navbar-container container-fluid">
        <!-- Navbar Collapse -->
        <div class="collapse navbar-collapse navbar-collapse-toolbar" id="site-navbar-collapse">
            <!-- Navbar Toolbar -->
            <ul class="nav navbar-toolbar">
                <li class="nav-item hidden-float" id="toggleMenubar">
                    <a class="nav-link" data-toggle="menubar" href="#" role="button">
                        <i class="icon hamburger hamburger-arrow-left">
                            <span class="sr-only">Toggle menubar</span>
                            <span class="hamburger-bar"></span>
                        </i>
                    </a>
                </li>

            </ul>
            <!-- End Navbar Toolbar -->

            <!-- Navbar Toolbar Right -->
            <ul class="nav navbar-toolbar navbar-right navbar-toolbar-right">
                <li class="nav-item dropdown">
                    <a class="nav-link navbar-avatar" data-toggle="dropdown" href="#" aria-expanded="false"
                       data-animation="scale-up" role="button">
              <span class="avatar avatar-online">
                <img src="material/global/portraits/5.jpg" alt="...">
                <i></i>
              </span>
                    </a>
                    <div class="dropdown-menu" role="menu">
                        <a class="dropdown-item" href="javascript:void(0)" role="menuitem"><i class="icon md-account"
                                                                                              aria-hidden="true"></i>
                            <?php echo $user_name; ?></a>

                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="logout.php" role="menuitem"><i class="icon md-power"
                                                                                      aria-hidden="true"></i>
                            Logout</a>
                    </div>
                </li>
            </ul>
            <!-- End Navbar Toolbar Right -->
        </div>
        <!-- End Navbar Collapse -->

        <!-- Site Navbar Seach -->
        <div class="collapse navbar-search-overlap" id="site-navbar-search">
            <form role="search">
                <div class="form-group">
                    <div class="input-search">
                        <i class="input-search-icon md-search" aria-hidden="true"></i>
                        <input type="text" class="form-control" name="site-search" placeholder="Search...">
                        <button type="button" class="input-search-close icon md-close" data-target="#site-navbar-search"
                                data-toggle="collapse" aria-label="Close"></button>
                    </div>
                </div>
            </form>
        </div>
        <!-- End Site Navbar Seach -->
    </div>
</nav>
<div class="site-menubar site-menubar-light">
    <div class="site-menubar-body">
        <div>
            <div>
                <ul class="site-menu" data-plugin="menu">
                    <li class="site-menu-item">
                        <a href="index.php">
                            <i class="site-menu-icon md-view-dashboard" aria-hidden="true"></i>
                            <span class="site-menu-title">Task Board</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>


<div class="page">
    <div class="page-header">
        <h1 class="page-title">Main Board</h1>
    </div>
    <div class="page-content">
        <ul class="taskboard-stages ui-sortable" id="append_main_task">
            <?php
            $i = 1;

            $sql = "SELECT * FROM `task_master` WHERE `user_id` = '$user_id' ORDER  BY `id` ASC ";
            //                                        echo $sql;
            $result = mysqli_query($conn, $sql) or trigger_error("Query Failed! SQL: $sql - Error: " . mysqli_error($conn));
            while ($row = mysqli_fetch_assoc($result)) {
                $id = $row['id']; ?>
                <li class="taskboard-stage" draggable="true" id="main_box<?php echo $id; ?>">
                    <header class="taskboard-stage-header ui-sortable-handle">
                        <div class="taskboard-stage-actions float-right">
                            <div class="dropdown">
                                <a data-toggle="dropdown" href="#" aria-expanded="false"><i class="icon md-chevron-down"
                                                                                            aria-hidden="true"></i></a>
                                <div class="dropdown-menu bullet" role="menu">
                                    <a class="taskboard-stage-rename dropdown-item"
                                       id="rename_click--<?php echo $id; ?>"
                                       href="javascript:void(0)"
                                       role="menuitem"><i class="icon md-edit" aria-hidden="true"></i>Rename</a>
                                    <a class="taskboard-stage-delete dropdown-item duplicate_main"
                                       id="duplicate_main--<?php echo $id; ?>"
                                       href="javascript:void(0)"
                                       role="menuitem"><i class="icon md-copy" aria-hidden="true"></i>Duplicate List</a>
                                    <a class="taskboard-stage-delete dropdown-item delete_main"
                                       id="delete_main--<?php echo $id; ?>"
                                       href="javascript:void(0)"
                                       role="menuitem"><i class="icon md-delete" aria-hidden="true"></i>Delete List</a>
                                    <a class="taskboard-stage-delete dropdown-item delete_completed"
                                       id="delete_completed--<?php echo $id; ?>"
                                       href="javascript:void(0)"
                                       role="menuitem" style="text-decoration: line-through;">
                                        <i class="icon md-delete" aria-hidden="true">::</i> Delete All Completed
                                        Task</a>
                                    <div class="taskboard-stage-rename-wrap" id="rename_show<?php echo $id; ?>">
                                        <div class="form-group">
                                            <input class="form-control taskboard-stage-rename-input" type="text"
                                                   value="<?php echo $row['task_name']; ?>"
                                                   id="rename<?php echo $id; ?>">
                                        </div>
                                        <button class="btn btn-primary btn-block save_rename taskboard-stage-rename-save"
                                                id="save_rename--<?php echo $id; ?>" type="button">
                                            Save
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h5 class="taskboard-stage-title font-weight-600"
                            id="task_head<?php echo $id; ?>"><?php echo $row['task_name']; ?></h5>
                    </header>
                    <div class="taskboard-stage-content">
                        <ul class="list-group taskboard-list ui-sortable">
                            <?php
                            $sql1 = "SELECT * FROM `sub_task` WHERE `main_task_id` = '$id' AND `is_complete` = 0 ORDER  BY `id` DESC";
                            //                                        echo $sql;
                            $result1 = mysqli_query($conn, $sql1) or trigger_error("Query Failed! SQL: $sql1 - Error: " . mysqli_error($conn));
                            while ($row1 = mysqli_fetch_assoc($result1)) {
                                $sid = $row1['id'];
                                ?>
                                <li class="list-group-item sub_list <?php if (($row1['is_urgent'] == 1) && ($row1['is_important'] == 1)) {
                                    echo 'priority-urgent';
                                } elseif (($row1['is_urgent'] == 1) || ($row1['is_important'] == 1)) {
                                    echo 'priority-high';
                                } ?>" id="sub_list<?php echo $sid; ?>"
                                    data-taskboard="slidePanel"
                                    data-url="panel.tpl">
                                    <div class="checkbox-custom checkbox-primary">
                                        <input type="checkbox" class="add_to_complete"
                                               id="add_to_complete--<?php echo $sid; ?>"
                                               name="checkbox">
                                        <label class="task-title sub_task_head font-weight-600"
                                               id="sub_task_head<?php echo $sid; ?>"><?php echo $row1['sub_task_name']; ?></label><br><br>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <input type="checkbox" class="add_to_urgent"
                                                       id="add_to_urgent--<?php echo $sid; ?>"
                                                       name="checkbox"
                                                       <?php if ($row1['is_urgent'] == 1){ ?>checked="checked" <?php } ?>>
                                                <label class="task-title"
                                                       <?php if ($row1['is_urgent'] == 1){ ?>style="text-decoration: underline;color:red;" <?php } ?>>
                                                    <?php if ($row1['is_urgent'] == 1) {
                                                        echo 'Urgent';
                                                    } else {
                                                        echo 'Not Urgent';
                                                    } ?></label>


                                            </div>
                                            <div class="col-md-6">
                                                <input type="checkbox" class="add_to_important"
                                                       id="add_to_important--<?php echo $sid; ?>"
                                                       name="checkbox"
                                                       <?php if ($row1['is_important'] == 1){ ?>checked="checked" <?php } ?>>
                                                <label class="task-title"
                                                       <?php if ($row1['is_important'] == 1){ ?>style="text-decoration: underline;color:#00A751;" <?php } ?>>
                                                    <?php if ($row1['is_important'] == 1) {
                                                        echo 'Important';
                                                    } else {
                                                        echo 'Not Important';
                                                    } ?></label>


                                            </div>
                                        </div>
                                        <header class="">
                                            <div class="taskboard-stage-actions float-right">
                                                <div class="dropdown" style="margin-top: -65px;">
                                                    <!--                                                    <a data-toggle="dropdown" href="#" aria-expanded="false"><i class="icon wb-menu"-->
                                                    <!--                                                                                                                aria-hidden="true"></i></a>-->
                                                    <a data-toggle="dropdown" href="#" aria-expanded="false">
                                                        <div class="sub_menu" style="float: right;">
                                                            <div class="m"></div>
                                                            <div class="m"></div>
                                                            <div class="m"></div>
                                                        </div>
                                                    </a>
                                                    <div class="dropdown-menu bullet"
                                                         id="sub_menu_box<?php echo $sid; ?>" role="menu">
                                                        <a class=" dropdown-item rename_sub"
                                                           id="rename_sub--<?php echo $sid . '--' . $id; ?>"
                                                           href="javascript:void(0)"
                                                           role="menuitem"><i class="icon md-edit"
                                                                              aria-hidden="true"></i>Rename</a>
                                                        <a class="taskboard-stage-rename dropdown-item dublicate_sub"
                                                           id="dublicate_sub--<?php echo $sid . '--' . $id; ?>"
                                                           href="javascript:void(0)"
                                                           role="menuitem"><i class="icon md-copy"
                                                                              aria-hidden="true"></i>Duplicate Task</a>
                                                        <a class="taskboard-stage-delete delete_sub dropdown-item"
                                                           id="delete_sub--<?php echo $sid; ?>"
                                                           href="javascript:void(0)"
                                                           role="menuitem"><i class="icon md-delete"
                                                                              aria-hidden="true"></i>Delete</a>
                                                        <div class="taskboard-stage-rename-wrap"
                                                             id="rename_sub_show<?php echo $sid; ?>">
                                                            <div class="form-group">
                                                                <input class="form-control taskboard-stage-rename-input"
                                                                       type="text"
                                                                       value="<?php echo $row1['sub_task_name']; ?>"
                                                                       id="rename_sub_in<?php echo $sid; ?>">
                                                            </div>
                                                            <button class="btn btn-primary btn-block save_rename_sub taskboard-stage-rename-save"
                                                                    id="save_rename_sub--<?php echo $sid . '--' . $id; ?>"
                                                                    type="button">
                                                                Save
                                                            </button>
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>
                                        </header>

                                        <!--                                        <div class="sub_menu" style="float: right">-->
                                        <!--                                            <div class="m"></div>-->
                                        <!--                                            <div class="m"></div>-->
                                        <!--                                            <div class="m"></div>-->
                                        <!--                                        </div>-->
                                    </div>
                                    <div class="w-full">
                                        <div class="task-badges">
                                            <!--                                            <span class="task-badge task-badge-subtask icon md-calendar">10/29</span>-->
                                            <!--                                            <span class="task-badge task-badge-subtask icon md-format-list-bulleted">-->
                                            <div class="clickable-text daterange__picker daterange__picker--start_date">
                                                <input class="last_date_input" type="text" name="start_date">
                                                <span class="btn"
                                                      style="border-radius: 40px;color: rgb(24, 144, 255);width: 150px;height: 35px;margin: 25px 0px 15px -145px;"
                                                      id="last_date--<?php echo $sid; ?>">
                                                        <?php
                                                        if ($row1['last_date'] != '0000-00-00 00:00:00') {
                                                            echo date_format(date_create($row1['last_date']), "D , M d ");
                                                        } else {
                                                            ?>
                                                            <span class="task-badge task-badge-subtask icon md-calendar"></span><?php } ?></span>
                                            </div>
                                        </div>

                                    </div>
                                </li>
                            <?php } ?>
                        </ul>
                        <div class="action-wrap">
                            <a id="sub_task--<?php echo $id; ?>" class="sub_task add-item-toggle" href="#"><i
                                        class="icon md-plus"
                                        aria-hidden="true"></i>Add Task</a>
                            <div class="add-item-wrap show_task_name" id="show_task_name<?php echo $id; ?>">
                                <!--                                <form class="add-item" role="form" method="post" action="#">-->
                                <div class="form-group">
                                    <label class="form-control-label mb-15" for="name">Task name:</label>
                                    <input class="form-control sub_task_name" id="sub_task_name<?php echo $id; ?>"
                                           type="text"
                                           placeholder="Sub Task name" name="sub_task_name">
                                </div>
                                <div class="form-group text-right">
                                    <a id="cancel_sub_task<?php echo $id; ?>"
                                       class="btn btn-sm btn-white btn-pure add-item-cancel">Cancel</a>
                                    <button type="button" id="add_sub_task<?php echo $id; ?>"
                                            class="btn btn-primary add-item-add">Add
                                    </button>
                                </div>
                                <!--                                </form>-->
                            </div>
                        </div>
                        <?php $sql2 = "SELECT * FROM `sub_task` WHERE `main_task_id` = '$id' AND `is_complete` = 1 ORDER  BY `id` DESC";
                        //                                        echo $sql;
                        $result2 = mysqli_query($conn, $sql2) or trigger_error("Query Failed! SQL: $sql2 - Error: " . mysqli_error($conn));
                        if (mysqli_num_rows($result2)) { ?>
                            <div class="action-wrap">
                                <a class="completed_drop add-item-toggle" href="#"><i
                                            class="icon md-chevron-down"
                                            aria-hidden="true"></i>Completed</a>
                                <?php while ($row2 = mysqli_fetch_assoc($result2)) {
                                    $rid = $row2['id'];
                                    ?>
                                    <div class="checkbox-custom checkbox-primary" id="complete_list<?php echo $rid; ?>">
                                        <input type="checkbox" class="remove_from_complete"
                                               id="remove_from_complete--<?php echo $rid; ?>" checked="checked"
                                               name="checkbox">
                                        <label style="text-decoration: line-through"
                                               class="task-title"><?php echo $row2['sub_task_name']; ?>
                                        </label><i class="icon md-delete del_sub_completed"
                                                   id="del_sub_completed--<?php echo $rid; ?>" style="float: right"
                                                   aria-hidden="true"></i>

                                    </div>
                                <?php } ?>
                            </div>
                        <?php } ?>
                    </div>
                </li>
            <?php } ?>
        </ul>
    </div>
</div>
<!-- Site Action -->
<!--<div class="site-action" data-toggle="modal" data-target="#addStageFrom" style="top:86px;left:328px" data-plugin="actionBtn">-->
<div class="site-action" data-toggle="modal" data-target="#addStageFrom" data-plugin="actionBtn">
    <button type="button" class="site-action-toggle btn-raised btn btn-success btn-floating">
        <i class="icon md-plus" aria-hidden="true"></i>
    </button>
</div>
<!-- End Site Action -->
<div class="modal fade" id="addStageFrom" aria-hidden="true" aria-labelledby="addStageFrom"
     role="dialog" tabindex="-1">
    <div class="modal-dialog modal-simple">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" aria-hidden="true" data-dismiss="modal">×</button>
                <h4 class="modal-title">Create New Group</h4>
            </div>
            <!--            <form action="index.php" id="add_task_form" method="post" role="form">-->
            <div class="modal-body">

                <div class="form-group">
                    <input type="text" class="form-control" id="task_name" name="task_name" placeholder="Task Name">
                </div>

            </div>
            <div class="modal-footer text-left">
                <button id="taskcreate" class="btn btn-primary" data-dismiss="modal" type="button">Create Task
                </button>
                <a class="btn btn-sm btn-white btn-pure" data-dismiss="modal" href="javascript:void(0)">Cancel</a>
            </div>
            <!--            </form>-->
        </div>
    </div>
</div>


<!-- Footer -->
<footer class="site-footer">
    <div class="site-footer-legal">© <?php echo date('Y'); ?> <a
                href="https://nithra.mobi/" target="_blank">Nithra Apps India Pvt Ltd</a></div>
    <div class="site-footer-right">
        Crafted with <i class="red-600 icon md-favorite"></i> by <a href="#">
            Preethika</a>
    </div>
</footer>
<!-- Core  -->
<script src="material/global/vendor/babel-external-helpers/babel-external-helpersfd53.js?v4.0.1"></script>
<script src="material/global/vendor/jquery/jquery.minfd53.js?v4.0.1"></script>
<script src="material/global/vendor/popper-js/umd/popper.minfd53.js?v4.0.1"></script>
<script src="material/global/vendor/bootstrap/bootstrap.minfd53.js?v4.0.1"></script>
<script src="material/global/vendor/animsition/animsition.minfd53.js?v4.0.1"></script>
<script src="material/global/vendor/mousewheel/jquery.mousewheel.minfd53.js?v4.0.1"></script>
<script src="material/global/vendor/asscrollbar/jquery-asScrollbar.minfd53.js?v4.0.1"></script>
<script src="material/global/vendor/asscrollable/jquery-asScrollable.minfd53.js?v4.0.1"></script>
<script src="material/global/vendor/ashoverscroll/jquery-asHoverScroll.minfd53.js?v4.0.1"></script>
<script src="material/global/vendor/waves/waves.minfd53.js?v4.0.1"></script>

<!-- Plugins -->
<script src="material/global/vendor/switchery/switchery.minfd53.js?v4.0.1"></script>
<script src="material/global/vendor/intro-js/intro.minfd53.js?v4.0.1"></script>
<script src="material/global/vendor/screenfull/screenfull.minfd53.js?v4.0.1"></script>
<script src="material/global/vendor/slidepanel/jquery-slidePanel.minfd53.js?v4.0.1"></script>

<!-- Plugins For This Page -->
<script src="material/global/vendor/jquery-ui/jquery-ui.minfd53.js?v4.0.1"></script>
<script src="material/global/vendor/bootstrap-select/bootstrap-select.minfd53.js?v4.0.1"></script>
<script src="material/global/vendor/jquery-selective/jquery-selective.minfd53.js?v4.0.1"></script>
<!--<script src="material/global/vendor/bootstrap-datepicker/bootstrap-datepicker.minfd53.js?v4.0.1"></script>-->
<script src="material/global/vendor/bootstrap-markdown/bootstrap-markdownfd53.js?v4.0.1"></script>
<script src="material/global/vendor/bootbox/bootbox.minfd53.js?v4.0.1"></script>

<!-- Scripts -->
<script src="material/global/js/State.minfd53.js?v4.0.1"></script>
<script src="material/global/js/Component.minfd53.js?v4.0.1"></script>
<script src="material/global/js/Plugin.minfd53.js?v4.0.1"></script>
<script src="material/global/js/Base.minfd53.js?v4.0.1"></script>
<script src="material/global/js/Config.minfd53.js?v4.0.1"></script>

<script src="material/iconbar/assets/js/Section/Menubar.minfd53.js?v4.0.1"></script>
<script src="material/iconbar/assets/js/Section/Sidebar.minfd53.js?v4.0.1"></script>
<script src="material/iconbar/assets/js/Section/PageAside.minfd53.js?v4.0.1"></script>
<script src="material/iconbar/assets/js/Plugin/menu.minfd53.js?v4.0.1"></script>

<!-- Config -->
<script src="material/global/js/config/colors.minfd53.js?v4.0.1"></script>
<script src="material/iconbar/assets/js/config/tour.minfd53.js?v4.0.1"></script>
<script>
    Config.set('assets', '../../assets');
</script>

<!-- Page -->
<script src="material/iconbar/assets/js/Site.minfd53.js?v4.0.1"></script>
<script src="material/global/js/Plugin/asscrollable.minfd53.js?v4.0.1"></script>
<script src="material/global/js/Plugin/slidepanel.minfd53.js?v4.0.1"></script>
<script src="material/global/js/Plugin/switchery.minfd53.js?v4.0.1"></script>

<script src="material/global/js/Plugin/bootstrap-select.minfd53.js?v4.0.1"></script>
<!--<script src="material/global/js/Plugin/bootstrap-datepicker.minfd53.js?v4.0.1"></script>-->
<script src="material/global/js/Plugin/bootbox.minfd53.js?v4.0.1"></script>


<script src="material/iconbar/assets/js/BaseApp.minfd53.js?v4.0.1"></script>
<script src="material/iconbar/assets/js/App/Taskboard.minfd53.js?v4.0.1"></script>

<script src="material/iconbar/assets/examples/js/apps/taskboard.minfd53.js?v4.0.1"></script>
<script src="material2/base/assets/data/taskboard.json"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.5.5/angular.min.js"></script>
<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>

<!-- Google Analytics -->
<script>
    (function (i, s, o, g, r, a, m) {
        i['GoogleAnalyticsObject'] = r;
        i[r] = i[r] || function () {
            (i[r].q = i[r].q || []).push(arguments)
        }, i[r].l = 1 * new Date();
        a = s.createElement(o),
            m = s.getElementsByTagName(o)[0];
        a.async = 1;
        a.src = g;
        m.parentNode.insertBefore(a, m)
    })(window, document, 'script', '../../../../../../www.google-analytics.com/analytics.js',
        'ga');

    ga('create', 'UA-65522665-1', 'auto');
    ga('send', 'pageview');
</script>
<script>

    $(document).ready(function () {
        $('.taskboard-stages').on('click', '.daterange__picker', function (e) {
            $(e.currentTarget).find('input').datepicker('show');
        });
            // $('.taskboard-stages').on('click', '.daterange__picker',
            // function (e) {
            //     $(e.currentTarget).find('input').datepicker('show');
            // });

        var _onSelect = function (selectedDate, e) {
            var $span = e.input.next('span');
            // var date_for = new Date(selectedDate);
            // var newDate = date_for.toString('D ,M d');
            // $span.text(newDate);
            var last_id = $span.attr('id');
            var splitid = last_id.split('--')
            var id = (splitid[1]);

            $.post('index.php',
                {
                    last_date_id: id,
                    last_date: selectedDate
                },
                function (data, status) {
                    // console.log(data);
                    location.reload();
                    // $('#show_task_name' + id).hide();
                    // $('.sub_task').show();
                });
        };

        $('.last_date_input').datepicker({onSelect: _onSelect});

        // $('.taskboard-stages').on('click', '#taskcreate',function () {
        $('#taskcreate').click(function () {
            var task_name = $('#task_name').val();

            if (task_name != '') {

                $.post('index.php',
                    {
                        task_name: task_name
                    },
                    function (data, status) {
                        console.log(data);
                        $('#append_main_task').append(data)
                        $('#task_name').val('');
                    });
            } else {
                alert('Please enter task name');
                return false;
            }
        });
        $('.taskboard-stages').on('click', '.sub_task', function () {
            // $('.sub_task').click(function () {
            var sub_task_id = $(this).attr('id');

            var splitid = sub_task_id.split('--')
            var id = (splitid[1]);
            // alert(id)
            // $('#'+sub_task_id).css("display", "none");
            $(this).hide();
            $('#show_task_name' + id).show();

            $('#add_sub_task' + id).click(function () {
                var sub_task_name = $('#sub_task_name' + id).val();
                var self = this;
                if (sub_task_name != '') {
                    $.post('index.php',
                        {
                            main_task_id: id,
                            sub_task_name: sub_task_name
                        },
                        function (data, status) {
                            $('#show_task_name' + id).hide();
                            $('.sub_task').show();
                            // console.log(data);
                            //$('#add_sub_task24').closest('.action-wrap').prev().prepend('<li></li>')
                            // console.log($(self), $(self).closest('.action-wrap'), $(self).closest('.action-wrap').prev())
                            $(self).closest('.action-wrap').prev().prepend(data);
                            $('#sub_task_name' + id).val('');
                            location.reload();
                        });
                } else {
                    $('#show_task_name' + id).hide();
                    $('.sub_task').show();
                }

            });
            $('#cancel_sub_task' + id).click(function () {
                $('#show_task_name' + id).hide();
                $('.sub_task').show();
            });
        });
        // $('.taskboard-stage-rename').click(function () {
        $('.taskboard-stages').on('click', '.taskboard-stage-rename', function () {
            // alert('check');
            var rename_id = $(this).attr('id');
            var splitid = rename_id.split('--')
            var id = (splitid[1]);
            $(document).find('#rename_show' + id).show();
            $(document).find('#rename_click--' + id).hide();
            $(document).find('#delete_main--' + id).hide();
            $(document).find('#delete_completed--' + id).hide();
            $(document).find('#duplicate_main--' + id).hide();
            return false;

        });
        $('.taskboard-stages').on('click', '.rename_sub', function () {
            // alert('check');
            var rename_sub_id = $(this).attr('id');
            var splitid = rename_sub_id.split('--')
            var id = (splitid[1]);
            var main_id = (splitid[2]);
            $(document).find('#rename_sub_show' + id).show();
            $(document).find('#rename_sub--' + id + '--' + main_id).hide();
            $(document).find('#dublicate_sub--' + id + '--' + main_id).hide();
            $(document).find('#delete_sub--' + id).hide();
            return false;

        });

        $('.taskboard-stages').on('click', '.save_rename', function () {
            // $('.save_rename').click(function () {
            var save_rename = $(this).attr('id');
            var splitid = save_rename.split('--')
            var id = (splitid[1]);

            var rename = $('#rename' + id).val();
            if (rename != '') {
                $.post('index.php',
                    {
                        main_task_id: id,
                        rename: rename
                    },
                    function (data, status) {
                        $(document).find('#task_head' + id).html(data);
                        $(document).find('#rename_show' + id).hide();
                        $(document).find('#delete_main--' + id).show();
                        $(document).find('#rename_click--' + id).show();
                        $(document).find('#delete_completed--' + id).show();
                        $(document).find('#duplicate_main--' + id).show();
                    });
            }

        });
        $('.taskboard-stages').on('click', '.save_rename_sub ', function () {
            var save_rename_sub = $(this).attr('id');
            var splitid = save_rename_sub.split('--')
            var id = (splitid[1]);
            var main_id = (splitid[2]);

            var rename_sub = $('#rename_sub_in' + id).val();
            if (rename_sub != '') {
                $.post('index.php',
                    {
                        sub_rename_id: id,
                        rename_sub: rename_sub
                    },
                    function (data, status) {
                        $(document).find('#sub_task_head' + id).html(data);
                        $(document).find('#rename_sub_show' + id).hide();
                        $(document).find('#rename_sub--' + id + '--' + main_id).show();
                        $(document).find('#dublicate_sub--' + id + '--' + main_id).show();
                        $(document).find('#delete_sub--' + id).show();
                    });
            }

        });
        $('.date_save').click(function () {
            alert($('#taskDatepickerInput').val());
        });
        $('.add_to_complete').click(function () {
            var add_to_complete = $(this).attr('id');
            var splitid = add_to_complete.split('--')
            var id = (splitid[1]);
            // $(document).find('#show_completed_name' + id).show();

            $.post('index.php',
                {
                    add_to_complete: id
                },
                function (data, status) {
                    // console.log(data);
                    location.reload();
                    // $('#show_task_name' + id).hide();
                    // $('.sub_task').show();
                });
        });
        $('.taskboard-stages').on('click', '.add_to_urgent', function () {
            var add_to_urgent = $(this).attr('id');
            var splitid = add_to_urgent.split('--')
            var id = (splitid[1]);
            // $(document).find('#show_completed_name' + id).show();

            $.post('index.php',
                {
                    add_to_urgent: id
                },
                function (data, status) {
                    // console.log(data);
                    location.reload();
                    // $('#show_task_name' + id).hide();
                    // $('.sub_task').show();
                });
        });
        $('.taskboard-stages').on('click', '.add_to_important', function () {
            var add_to_important = $(this).attr('id');
            var splitid = add_to_important.split('--')
            var id = (splitid[1]);
            // $(document).find('#show_completed_name' + id).show();

            $.post('index.php',
                {
                    add_to_important: id
                },
                function (data, status) {
                    // console.log(data);
                    location.reload();
                    // $('#show_task_name' + id).hide();
                    // $('.sub_task').show();
                });
        });
        $('.remove_from_complete').click(function () {
            var remove_from_complete = $(this).attr('id');
            var splitid = remove_from_complete.split('--')
            var id = (splitid[1]);
            // $(document).find('#show_completed_name' + id).show();

            $.post('index.php',
                {
                    remove_from_complete: id
                },
                function (data, status) {
                    location.reload();
                    // console.log(data);
                });
        });
        $('.delete_sub').click(function () {
            var delete_sub = $(this).attr('id');
            var splitid = delete_sub.split('--')
            var sid = (splitid[1]);
            // $(document).find('#show_completed_name' + id).show();
            // alert(delete_sub)
            $.post('index.php',
                {
                    delete_sub: sid
                },
                function (data, status) {
                    // console.log(data);
                    $('#sub_list' + sid).hide();
                });
        });
        $('.del_sub_completed').click(function () {
            var delete_sub = $(this).attr('id');
            var splitid = delete_sub.split('--')
            var sid = (splitid[1]);
            // $(document).find('#show_completed_name' + id).show();
            // alert(delete_sub)
            $.post('index.php',
                {
                    delete_sub: sid
                },
                function (data, status) {
                    // console.log(data);
                    $('#complete_list' + sid).hide();
                });
        });
        $('.taskboard-stages').on('click', '.dublicate_sub', function () {
            // $('.dublicate_sub').click(function () {
            var dublicate_sub = $(this).attr('id');
            var splitid = dublicate_sub.split('--')
            var sid = (splitid[1]);
            var mid = (splitid[2]);
            // alert(delete_sub)
            $.post('index.php',
                {
                    dublicate_sub: sid,
                    main_id: mid
                },
                function (data, status) {
                    // console.log(data);
                    $('#sub_menu_box' + sid).hide();
                    location.reload();
                });
        });

        $('.delete_main').click(function () {
            var delete_main = $(this).attr('id');
            var splitid = delete_main.split('--')
            var mid = (splitid[1]);
            // alert(delete_main)
            $.post('index.php',
                {
                    delete_main: mid
                },
                function (data, status) {
                    // console.log(data);
                    $('#main_box' + mid).hide();
                });
        });
        $('.duplicate_main').click(function () {
            var duplicate_main = $(this).attr('id');
            var splitid = duplicate_main.split('--')
            var dmid = (splitid[1]);
            // alert(duplicate_main)
            $.post('index.php',
                {
                    duplicate_main: dmid
                },
                function (data, status) {
                    // console.log(data);
                    location.reload();
                });
        });
        $('.delete_completed').click(function () {
            var delete_completed = $(this).attr('id');
            var splitid = delete_completed.split('--')
            var mcid = (splitid[1]);
            // alert(delete_completed)
            $.post('index.php',
                {
                    delete_completed: mcid
                },
                function (data, status) {
                    // console.log(data);
                    location.reload();
                });
        });


    });
</script>
</body>

</html>